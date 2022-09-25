<?php

use Illuminate\Support\Facades\Route;

use App\Http\Apps\Admin\Modules\Web\Controllers\Shop\ProductsController as Controller;

Route::get("/products", [Controller::class, "getProducts"]);
Route::get("/products/create", [Controller::class, "getCreateProduct"]);
Route::get("/product/{product_id}/edit", [Controller::class, "getEditProduct"]);
