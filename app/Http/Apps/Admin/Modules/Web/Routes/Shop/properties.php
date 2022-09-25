<?php

use Illuminate\Support\Facades\Route;

use App\Http\Apps\Admin\Modules\Web\Controllers\Shop\PropertiesController as Controller;

Route::prefix("/property-groups")->group(function () {
    Route::get("/", [Controller::class, "getGroups"]);
    Route::get("/create", [Controller::class, "getCreateGroup"]);
    Route::post("/create", [Controller::class, "postCreateGroup"]);
});
Route::prefix("/property-group/{group_id}")->group(function () {
    Route::prefix("/properties")->group(function () {
        Route::get("/", [Controller::class, "getGroupProperties"]);
        Route::get("/create", [Controller::class, "getCreateProperty"]);
        Route::post("/create", [Controller::class, "postCreateProperty"]);
    });
    Route::get("/edit", [Controller::class, "getEditGroup"]);
    Route::post("/edit", [Controller::class, "postEditGroup"]);
    Route::get("/delete", [Controller::class, "getDeleteGroup"]);
});
Route::prefix("/property/{property_id}")->group(function () {
    Route::get("/edit", [Controller::class, "getEditProperty"]);
    Route::post("/edit", [Controller::class, "postEditProperty"]);
    Route::get("/delete", [Controller::class, "getDeleteProperty"]);
});
