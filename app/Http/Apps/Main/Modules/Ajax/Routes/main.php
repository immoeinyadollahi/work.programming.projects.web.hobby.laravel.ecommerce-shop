<?php

use Illuminate\Support\Facades\Route;

use App\Http\Middlewares\Auth;

use App\Http\Apps\Main\Modules\Ajax\Controllers\MainController as Controller;

Route::middlewares(Auth::middleware("ajax"))->group(function () {
    Route::get("/checkout/info", [Controller::class, "getCheckoutInfo"]);
});
