<?php

use Illuminate\Support\Facades\View;

use App\Settings\General as GeneralSettings;
use App\Database\Models\Category;
use App\Database\Models\Cart;
use App\Database\Models\Coupon;
use App\Http\Exceptions\Handler as ExceptionHandler;

// Config
_set_config("http.module", [
    "name" => "web",
    "exception_handler" => [ExceptionHandler::class, "web"]
]);
// Views
$composers = [
    "main" => function ($view) {
        // User
        $user = _user();
        if ($user) {
            $user->load("profileImage");
            $user->favourite_products_count = $user->favoredProducts()->count();
        }
        $view->_withData("user", $user);
        // Cart
        $cart = Cart::getRequestCart();
        if ($cart) {
            $cart->load(["items.productSu.product.image", "items.productSu.variableProductTypeAttributes" => fn ($query) => $query->_orderedByPivot(), "items.productSu.variableProductTypeAttributes.attribute"]);
            $cart->info = $cart->getInfo(Coupon::getRequestCoupon());
        }
        $view->_withData("cart", $cart);
        // Categories
        $view->_withData("categories", Category::getTree());
        // Settings
        $view->_withData("settings", app(GeneralSettings::class));
    }
];
_register_pages_composers($composers);
_register_pages_creators([["views" => "pages.*", "composers" => "main", "exclude" => "pages.errors.500"]]);

View::addLocation(__DIR__ . "/../Views");
