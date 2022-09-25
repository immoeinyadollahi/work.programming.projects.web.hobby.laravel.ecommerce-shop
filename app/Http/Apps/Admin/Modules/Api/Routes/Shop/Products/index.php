<?php

use Illuminate\Support\Facades\Route;

Route::prefix("/products")->group(function () {
    require "main.php";
    require "media.php";
    require "specifications.php";
    require "properties.php";
    require "simple-type.php";
    require "VariableType/index.php";
});
