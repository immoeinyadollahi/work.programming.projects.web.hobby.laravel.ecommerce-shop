<?php

use Illuminate\Support\Facades\Route;

use App\Http\Middlewares\Auth;

use App\Http\Apps\Main\Modules\Web\Controllers\MainController as Controller;

Route::middlewares(Auth::middleware("web"))->group(function () {
    Route::get("/checkout", [Controller::class, "getCheckout"]);
    Route::post("/checkout", [Controller::class, "postCheckout"]);
    Route::get("/payment/redirect", [Controller::class, "getPaymentRedirect"])->name("payment-redirect");
    Route::get("/payment/callback", [Controller::class, "getPaymentCallback"])->name("payment-callback");
    Route::get("/wishlist", [Controller::class, "getWishlist"]);
    Route::post("/product/{product_id}/comment", [Controller::class, "postProductComment"]);
    Route::get("/favourite/product/{product_id}", [Controller::class, "getToggleFavouriteProduct"])->name("favourite.product");
    Route::view("/profile/phone", "pages.main.profile-phone", [])->name("profile-phone");
    Route::post("/profile/phone", [Controller::class, "postProfilePhone"]);
    Route::get("/profile/phone/resend-otp", [Controller::class, "getProfilePhoneResendOTP"]);
    Route::get("/profile/phone/verify", [Controller::class, "getProfilePhoneVerify"])->name("profile-phone-verify");
    Route::post("/profile/phone/verify", [Controller::class, "postProfilePhoneVerify"]);
});
Route::get("/", [Controller::class, "getIndex"]);
Route::get("/compare/{product_1}/{product_2?}/{product_3?}/{product_4?}", [Controller::class, "getCompare"])->name("compare");
Route::get("/product/{product_id}/{product_slug?}", [Controller::class, "getProduct"])->name("product");
Route::get("/post/{post_id}/{post_slug?}", [Controller::class, "getPost"])->name("post");
Route::get("/shop/{category_slug}", [Controller::class, "getShop"])->name("shop");
Route::get("/search", [Controller::class, "getSearch"])->name("search");
