<?php

namespace App\Http\Apps\Main\Modules\Ajax\Controllers;

use App\Classes\Base\Routing\Controller;
use App\Database\Models\Cart;
use App\Database\Models\Coupon;

class CartController extends Controller
{
    public function getInfo()
    {
        $cart = Cart::getRequestCart();
        if (!$cart) _http_abort(422);
        $cart->load("items");
        $cart->info = $cart->getInfo(Coupon::getRequestCoupon());
        return view("shared::partials.cart-info", ["cart" => $cart]);
    }
    public function patchItem($item_id)
    {
        $req = request();
        $request_cart = Cart::getRequestCart();
        $quantity = $req->input("quantity");
        $error = null;
        if (!$request_cart) $error = "سبد خرید شما خالی است";
        else {
            $cart_item = $request_cart->items()->find($item_id);
            if (!$cart_item) $error = "آیتم در سبد خرید شما یافت نشد"; // or we can abort to 404
            else if (!is_numeric($quantity) || ($quantity = (int) $quantity) < 1) $error = "اطلاعات صحیح نیست";
            else {
                $product_su =  $cart_item->productSu()->first();
                if ($product_su->stock === 0)  $error = "محصول مورد نظر در حال حاضر ناموجود است";
                else if ($product_su->stock < $quantity) $error = "موجودی انبار کمتر از تعداد انتخاب شده است";
                else {
                    $cart_item->quantity = $quantity;
                    $cart_item->save();
                }
            }
        }
        if ($error) _http_abort(422, $error);
        $request_cart->load("items");
        $request_cart->info = $request_cart->getInfo(Coupon::getRequestCoupon());
        return [
            "item_html" => view("shared::partials.cart-item", ["item" => $cart_item])->render(),
            "info_html" => view("shared::partials.cart-info", ["cart" => $request_cart])->render()
        ];
    }
}
