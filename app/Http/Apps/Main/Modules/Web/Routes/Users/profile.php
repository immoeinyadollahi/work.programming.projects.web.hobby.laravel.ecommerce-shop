<?php

use Illuminate\Support\Facades\Route;

use App\Http\Apps\Main\Modules\Web\Controllers\Users\ProfileController as Controller;

Route::prefix("/profile")->group(function () {
    Route::view("/", "pages.users.profile", [])->name("profile");
    Route::post("/basic", [Controller::class, "postProfileBasic"])->name("profile-basic");
    Route::post("/image", [Controller::class, "postProfileImage"])->name("profile-image");
});
