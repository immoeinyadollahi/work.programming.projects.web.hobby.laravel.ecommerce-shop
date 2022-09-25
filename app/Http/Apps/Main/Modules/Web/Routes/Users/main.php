<?php

use Illuminate\Support\Facades\Route;

use App\Http\Apps\Main\Modules\Web\Controllers\Users\MainController as Controller;

Route::get("/dashboard", [Controller::class, "getDashboard"])->name("dashboard");
Route::view("/change-password", "pages.users.change-password", [])->name("change-password");
Route::post("/change-password", [Controller::class, "postChangePassword"]);
