<?php

use Illuminate\Support\Facades\Route;

use App\Http\Middlewares\Auth;

Route::prefix("/shop")->middlewares(Auth::middleware("api"))->group(function () {
    require "specifications.php";
    require "Categories/index.php";
    require "Products/index.php";
});
