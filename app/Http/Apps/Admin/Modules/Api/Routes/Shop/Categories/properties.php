<?php

use Illuminate\Support\Facades\Route;

use App\Http\Apps\Admin\Modules\Api\Controllers\Shop\Categories\PropertiesController as Controller;

Route::prefix("/{category_id}")->group(function () {
    Route::prefix("/properties")->group(function () {
        Route::get("/", [Controller::class, "getProperties"]);
        Route::post("/save", [Controller::class, "postSaveProperties"]);
    });
});
Route::post("/properties/{property_id}/values/save", [Controller::class, "postSavePropertyValues"]);
