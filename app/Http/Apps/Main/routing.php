<?php

use Illuminate\Support\Facades\Route;

Route::domain("localhost")->name("main.")->bootstrap(__DIR__ . "/Middlewares/bootstrap.php")->group(function () {
    require "Modules/Ajax/routing.php";
    require "Modules/Api/routing.php";
    require "Modules/Web/routing.php";
});
