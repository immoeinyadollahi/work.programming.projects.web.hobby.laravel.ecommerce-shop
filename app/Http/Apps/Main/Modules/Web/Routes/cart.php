<?php

use Illuminate\Support\Facades\Route;

use App\Http\Apps\Main\Modules\Web\Controllers\CartController as Controller;

Route::prefix("/cart")->group(function () {
    Route::get("/", [Controller::class, "getCart"]);
    Route::get("/add/{product_su_id}/{quantity}", [Controller::class, "getAddToCart"]);
    Route::get("/remove/{item_id}", [Controller::class, "getRemoveItem"]);
});
