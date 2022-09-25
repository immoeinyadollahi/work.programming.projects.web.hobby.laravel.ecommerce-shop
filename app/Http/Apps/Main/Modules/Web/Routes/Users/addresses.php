<?php

use Illuminate\Support\Facades\Route;

use App\Http\Apps\Main\Modules\Web\Controllers\Users\AddressesController as Controller;

Route::prefix("/addresses")->group(function () {
    Route::get("/", [Controller::class, "getAddresses"])->name("addresses");
    Route::get("/add", [Controller::class, "getAddAddress"])->name("addresses.add");
    Route::post("/add", [Controller::class, "postAddAddress"]);
});
Route::prefix("/address")->group(function () {
    Route::get("/{address_id}/edit", [Controller::class, "getEditAddress"])->name("addresses.edit");
    Route::post("/{address_id}/edit", [Controller::class, "postEditAddress"]);
    Route::get("/{address_id}/remove", [Controller::class, "getRemoveAddress"])->name("addresses.remove");
});
