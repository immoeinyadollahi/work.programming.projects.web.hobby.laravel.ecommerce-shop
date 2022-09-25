<?php

use Illuminate\Support\Facades\Route;

use App\Http\Apps\Main\Modules\Api\Controllers\CouponsController as Controller;

Route::prefix("/coupon")->group(function () {
    Route::post("/", [Controller::class, "postCoupon"]);
    Route::get("/revoke", [Controller::class, "getRevokeCoupon"]);
});
