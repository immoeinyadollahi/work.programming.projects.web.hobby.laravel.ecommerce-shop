<?php

use Illuminate\Support\Facades\Route;

Route::prefix('/ajax')->name("ajax.")->middlewares("ajax")->bootstrap(__DIR__ . "/Middlewares/bootstrap.php")->groupWithFallback(function () {
    require "Routes/main.php";
    require "Routes/products.php";
    require "Routes/cart.php";
});
