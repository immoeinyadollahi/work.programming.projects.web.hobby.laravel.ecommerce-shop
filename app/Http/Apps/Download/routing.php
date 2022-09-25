<?php

use Illuminate\Support\Facades\Route;

Route::domain("dl.localhost")->bootstrap(__DIR__ . "/Middlewares/bootstrap.php")->groupWithFallback(function () {
});
