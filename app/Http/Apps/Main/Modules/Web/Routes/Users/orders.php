<?php

use Illuminate\Support\Facades\Route;

use App\Http\Apps\Main\Modules\Web\Controllers\Users\OrdersController as Controller;

Route::get("/orders", [Controller::class, "getOrders"])->name("orders");
Route::name("orders.")->group(function () {
    Route::get("/order/{order_id}", [Controller::class, "getOrder"])->name("order");
    Route::get("/order/{order_id}/pay", [Controller::class, "getPayOrder"])->name("pay-order");
});
