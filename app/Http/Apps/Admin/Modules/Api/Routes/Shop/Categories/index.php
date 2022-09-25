<?php

use Illuminate\Support\Facades\Route;

Route::prefix("/categories")->group(function () {
    require "media.php";
    require "attributes.php";
    require "properties.php";
});
