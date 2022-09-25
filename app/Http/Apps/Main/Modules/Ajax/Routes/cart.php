<?php

use Illuminate\Support\Facades\Route;

use App\Http\Apps\Main\Modules\Ajax\Controllers\CartController as Controller;

Route::prefix("/cart")->group(function () {
    Route::get("/info", [Controller::class, "getInfo"]);
    Route::patch("/{item_id}", [Controller::class, "patchItem"]);
});
