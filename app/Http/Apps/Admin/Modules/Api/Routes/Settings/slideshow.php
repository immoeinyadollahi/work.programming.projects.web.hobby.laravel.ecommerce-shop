<?php

use Illuminate\Support\Facades\Route;

use App\Http\Apps\Admin\Modules\Api\Controllers\Settings\SlideshowController as Controller;

Route::prefix("/slideshow/slides")->group(function () {
    Route::post("/", [Controller::class, "postSlide"]);
    Route::patch("/{slide_id}", [Controller::class, "patchSlide"]);
    Route::delete("/{slide_id}", [Controller::class, "deleteSlide"]);
    Route::post("/image", [Controller::class, "postSlideImage"]);
});
