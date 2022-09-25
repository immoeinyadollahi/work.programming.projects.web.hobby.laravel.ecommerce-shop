<?php

use Illuminate\Support\Facades\Route;

use App\Http\Middlewares\Auth;

use App\Http\Apps\Main\Modules\Web\Controllers\AccountController as Controller;

Route::middlewares(Auth::middleware("web", ["guest" => true]))->group(function () {
    Route::view("/register", "pages.account.register", []);
    Route::post("/register", [Controller::class, "postRegister"]);
    Route::view("/login", "pages.account.login", []);
    Route::post("/login", [Controller::class, "postLogin"]);
    Route::view("/forget-password", "pages.account.forget-password", []);
    Route::post("/forget-password", [Controller::class, "postForgetPassword"]);
    Route::view("/reset-password", "pages.account.reset-password", [])->name("reset-password");
    Route::post("/reset-password", [Controller::class, "postResetPassword"]);
});
Route::middlewares(Auth::middleware("web"))->group(function () {
    Route::get("/logout", [Controller::class, "getLogout"]);
    Route::get("/email/verify", [Controller::class, "getVerify"])->name("verify-email");
    Route::get("/email/resend-verification-mail", [Controller::class, "getResendEmailVerificationMail"]);
});
