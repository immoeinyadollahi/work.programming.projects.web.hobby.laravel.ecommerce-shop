<?php

use Illuminate\Support\Facades\Route;

use App\Http\Apps\Admin\Modules\Api\Controllers\Shop\Products\PropertiesController as Controller;

Route::prefix("/{product_id}")->group(function () {
    Route::prefix("/properties")->group(function () {
        Route::get("/", [Controller::class, "getProperties"]);
        Route::post("/save", [Controller::class, "postSave"]);
    });
});
