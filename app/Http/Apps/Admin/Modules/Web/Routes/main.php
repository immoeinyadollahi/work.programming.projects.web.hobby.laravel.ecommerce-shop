<?php

use Illuminate\Support\Facades\Route;

use App\Http\Middlewares\Auth;

use App\Http\Apps\Admin\Modules\Web\Controllers\MainController as Controller;

Route::middlewares(Auth::middleware("web"))->group(function () {
    Route::get("/", [Controller::class, "getIndex"]);
    Route::get("/settings", [Controller::class, "getSettings"]);
    Route::post("/settings", [Controller::class, "postSettings"]);
});
