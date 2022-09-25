<?php

use Illuminate\Support\Facades\Route;

use App\Http\Apps\Admin\Modules\Api\Controllers\Shop\Products\SpecificationsController as Controller;

Route::prefix("/{product_id}")->group(function () {
    Route::post("/specifications/groups", [Controller::class, "postGroup"]);
});
Route::prefix("/specifications")->group(function () {
    Route::post("/save", [Controller::class, "postSaveOrdering"]);
    Route::prefix("/groups")->group(function () {
        Route::prefix("/{group_id}")->group(function () {
            Route::patch("/", [Controller::class, "patchGroup"]);
            Route::delete("/", [Controller::class, "deleteGroup"]);
            Route::post("/items", [Controller::class, "postGroupItem"]);
        });
        Route::prefix("/items")->group(function () {
            Route::patch("/{item_id}", [Controller::class, "patchGroupItem"]);
            Route::delete("/{item_id}", [Controller::class, "deleteGroupItem"]);
        });
    });
});
