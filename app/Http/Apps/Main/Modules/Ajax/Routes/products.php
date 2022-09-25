<?php

use Illuminate\Support\Facades\Route;

use App\Http\Apps\Main\Modules\Ajax\Controllers\ProductsController as Controller;

Route::prefix("/products")->group(function () {
    Route::patch("/compare/", [Controller::class, "getCompareProducts"]);
    Route::get("/{product_id}/comments", [Controller::class, "getProductComments"]);
});
