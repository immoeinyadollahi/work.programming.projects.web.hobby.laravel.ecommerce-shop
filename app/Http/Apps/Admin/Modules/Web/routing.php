<?php

use Illuminate\Support\Facades\Route;

Route::name("web.")->middleware("web")->bootstrap(__DIR__ . "/Middlewares/bootstrap.php")->groupWithFallback(function () {
    require "Routes/main.php";
    require "Routes/account.php";
    require "Routes/shop/index.php";
});
