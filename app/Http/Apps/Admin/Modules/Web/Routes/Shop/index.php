<?php

use Illuminate\Support\Facades\Route;

use App\Http\Middlewares\Auth;

Route::prefix("/shop")->middlewares(Auth::middleware("web"))->group(function () {
    require "categories.php";
    require "products.php";
    require "properties.php";
});
