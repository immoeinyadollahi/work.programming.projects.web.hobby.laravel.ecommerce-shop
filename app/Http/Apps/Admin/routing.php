<?php

use Illuminate\Support\Facades\Route;

Route::domain("admin.localhost")->name("admin.")->bootstrap(__DIR__ . "/Middlewares/bootstrap.php")->group(function () {
    require "Modules/api/routing.php";
    require "Modules/web/routing.php";
});
