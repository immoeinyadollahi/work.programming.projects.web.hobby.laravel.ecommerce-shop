<?php

namespace App\Http\Apps\Main\Modules\Web\Controllers;

use App\Classes\Base\Routing\Controller;
use App\Database\Models\ProductSu;
use App\Database\Models\Cart;
use App\Database\Models\CartToken;

class CartController extends Controller
{
    public function getCart()
    {
        return view("pages.main.cart");
    }
    public function getAddToCart($product_su_id, $quantity)
    {
        $product_su = ProductSu::find($product_su_id);
        if (!$product_su) _http_abort(404);
        $error = null;
        $modified = false;
        if (!is_numeric($quantity) || ($quantity = (int) $quantity) < 1) $error = "اطلاعات صحیح نیست";
        else if ($product_su->stock === 0) $error = "محصول مورد نظر در حال حاضر ناموجود است";
        else if ($product_su->stock < $quantity) $error = "موجودی انبار کمتر از تعداد انتخاب شده است";
        else {
            $product_su_sale_price = $product_su->sale_price;
            $request_cart = Cart::getRequestCart();
            if ($request_cart) {
                $existing_item = $request_cart->items()->where("product_su_id", $product_su_id)->first();
                if ($existing_item) {
                    if ($quantity + $existing_item->quantity > $product_su->stock) $error = "موجودی انبار کمتر از مجموع تعداد این محصول در سبد خرید است";
                    else {
                        $existing_item->quantity += $quantity;
                        $existing_item->save();
                        $modified = true;
                    }
                } else {
                    $request_cart->items()->create(["quantity" => $quantity, "product_su_sale_price" => $product_su_sale_price, "product_su_id" => $product_su_id]);
                }
            } else {
                // if we don't create new cart on user login (if user doesn't have any cart) and only want to create new cart on adding first item, here if user exists, we can add user_id to new cart with request user id and don't create cart_id cookie
                $new_cart = Cart::create();
                $new_cart->items()->create(["quantity" => $quantity, "product_su_sale_price" => $product_su_sale_price, "product_su_id" => $product_su_id]);
                session()->put("cart_id", $new_cart->id);
                $cart_token = CartToken::createJwtToken(["cart_id" => $new_cart->id], 60 * 60 * 24);
                cookie()->queue(cookie("cart_id", $cart_token->token, 60 * 24)->withHttpOnly());
            }
        }
        if ($error) return back()->_withMessage($error, "danger");
        return back()->_withMessage($modified ? "کالا در سبد خرید بروزرسانی شد" : "کالا به سبد خرید اضافه شد", "success");
    }
    public function getRemoveItem($item_id)
    {
        $request_cart = Cart::getRequestCart();
        $error = null;
        if (!$request_cart) $error = "سبد خرید شما خالی است";
        else if (!$request_cart->items()->where("id", $item_id)->_deleteFirst()) $error = "آیتم در سبد خرید شما یافت نشد"; // or we can abort to 404
        if ($error) return back()->_withMessage($error, "danger");
        return back()->_withMessage("آیتم از سبد خرید حذف شد", 'success');
    }
}
