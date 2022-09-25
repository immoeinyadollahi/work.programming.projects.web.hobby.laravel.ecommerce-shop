<?php

use Illuminate\Support\Facades\Route;

use App\Http\Middlewares\Auth;

Route::prefix("/users")->name("users.")->middlewares(Auth::middleware("web"))->group(function () {
    require "main.php";
    require "addresses.php";
    require "orders.php";
    require "profile.php";
});
