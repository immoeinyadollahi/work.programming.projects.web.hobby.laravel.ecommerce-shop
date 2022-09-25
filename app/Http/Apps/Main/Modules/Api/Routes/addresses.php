<?php

use Illuminate\Support\Facades\Route;

use App\Http\Apps\Main\Modules\Api\Controllers\AddressesController as Controller;

Route::prefix("/addresses")->group(function () {
    Route::get("/provinces/{province_id}/cities", [Controller::class, "getProvinceCities"]);
});
