<?php

use Illuminate\Support\Facades\Route;

use App\Http\Middlewares\Auth;

Route::prefix("/settings")->middlewares(Auth::middleware("api"))->group(function () {
    require "main.php";
    require "slideshow.php";
});
