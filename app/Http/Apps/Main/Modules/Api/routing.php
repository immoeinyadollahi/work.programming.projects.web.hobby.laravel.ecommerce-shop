<?php

use Illuminate\Support\Facades\Route;

Route::prefix('/api')->name("api.")->middleware("api")->bootstrap(__DIR__ . "/Middlewares/bootstrap.php")->groupWithFallback(function () {
    require "Routes/products.php";
    require "Routes/categories.php";
    require "Routes/coupons.php";
    require "Routes/addresses.php";
});
