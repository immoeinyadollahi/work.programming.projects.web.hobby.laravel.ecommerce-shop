<?php

namespace App\Database\Models;

use Exception;

use App\Classes\Base\Database\Model;

class Cart extends Model
{
    protected $table = 'carts';

    public static function clearRequestCart()
    {
        CartToken::where("cart_id", session("cart_id"))->_deleteFirst();
        _remove_cookie("cart_token");
        session()->forget("cart_id");
    }
    public static function getRequestCart()
    {
        $req = request();
        $user = _user();
        if ($user) return $user->cart()->first();
        if ($session_cart_id = session("cart_id")) {
            if ($cart = self::find($session_cart_id)) return $cart;
            self::clearRequestCart();
        } else if ($cookie_cart_token = $req->cookie("cart_token")) {
            try {
                if ($token = CartToken::verifyJwtToken($cookie_cart_token)) {
                    if ($cart = self::find($token->cart_id)) {
                        session()->put("cart_id", $cart->id);
                        return $cart;
                    }
                }
            } catch (Exception $ex) {
            }
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class, "user_id");
    }
    public function items()
    {
        return $this->hasMany(CartItem::class, "cart_id");
    }

    public function getInfo($coupon = null)
    {
        [$items_final_price, $items_total_price] = $this->items->reduce(function ($acc, $item) {
            $product_su = $item->productSu;
            $acc[0] += $product_su->sale_price * $item->quantity;
            $acc[1] += $product_su->price * $item->quantity;
            return $acc;
        }, [0, 0]);
        $coupon_price = $coupon ? round(($items_final_price * $coupon->amount) / 100 / 1000) * 1000 : 0;
        $items_total_discount_price = $items_total_price - $items_final_price;
        $total_price = $items_total_price; // total price without any discount or coupon , can add shipping price later
        $payment_cost = $items_final_price - $coupon_price;
        $total_discount_price = $total_price - $payment_cost; // or $coupon_price + $items_total_discount_price
        return [
            "coupon" => $coupon,
            "coupon_price" => $coupon_price,
            "items_final_price" => $items_final_price,
            "items_total_price" => $items_total_price,
            "items_total_discount_price" => $items_total_discount_price,
            "items_total_discount_percent" => $items_total_discount_price ? floor((($items_total_discount_price) / $items_total_price) * 100) : 0,
            "total_discount_price" => $total_discount_price,
            "total_discount_percent" =>  $total_discount_price ? floor((($total_discount_price) / $total_price) * 100) : 0,
            "total_price" => $total_price,
            "payment_cost" => $payment_cost,
        ];
    }
}
