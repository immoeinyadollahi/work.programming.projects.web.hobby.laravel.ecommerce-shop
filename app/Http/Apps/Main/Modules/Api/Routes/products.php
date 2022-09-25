<?php

use Illuminate\Support\Facades\Route;

use App\Http\Apps\Main\Modules\Api\Controllers\ProductsController as Controller;

Route::get("/products/search", [Controller::class, "getSearch"]);
Route::get("/products/{product_id}/quickview", [Controller::class, "getQuickviewProduct"]);
