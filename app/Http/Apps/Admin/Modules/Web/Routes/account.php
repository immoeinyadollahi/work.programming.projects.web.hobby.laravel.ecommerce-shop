<?php

use Illuminate\Support\Facades\Route;

use App\Http\Middlewares\Auth;

use App\Http\Apps\Admin\Modules\Web\Controllers\AccountController as Controller;

Route::middlewares(Auth::middleware("web", ["guest" => true]))->group(function () {
    Route::view("/login", "pages.account.login");
    Route::post("/login", [Controller::class, "postLogin"]);
});
