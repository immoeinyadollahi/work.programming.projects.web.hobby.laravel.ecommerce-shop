<?php

namespace App\Http\Apps\Main\Modules\Ajax\Controllers;

use App\Classes\Base\Routing\Controller;
use App\Database\Models\Cart;
use App\Database\Models\Coupon;

class MainController extends Controller
{
    public function getCheckoutInfo()
    {
        $cart = Cart::getRequestCart();
        if (!$cart) _http_abort(422);
        $cart->load("items");
        $cart->info = $cart->getInfo(Coupon::getRequestCoupon());
        return view("shared::partials.checkout-info", ["cart" => $cart]);
    }
}
