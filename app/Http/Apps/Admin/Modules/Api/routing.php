<?php

use Illuminate\Support\Facades\Route;

Route::prefix('/api')->name("api.")->middleware("api")->bootstrap(__DIR__ . "/Middlewares/bootstrap.php")->groupWithFallback(function () {
    require "Routes/Settings/index.php";
    require "Routes/Shop/index.php";
});
