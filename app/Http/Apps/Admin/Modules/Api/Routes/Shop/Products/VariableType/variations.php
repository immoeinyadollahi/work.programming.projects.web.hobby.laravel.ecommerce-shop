<?php

use Illuminate\Support\Facades\Route;

use App\Http\Apps\Admin\Modules\Api\Controllers\Shop\Products\VariableType\VariationsController as Controller;

Route::prefix("/{product_id}/variable-type/variations")->group(function () {
    Route::get("/", [Controller::class, "getVariations"]);
    Route::get("/actions/{action_name}", [Controller::class, "getPerformAction"]);
});
Route::prefix("/variable-type/variations")->group(function () {
    Route::post("/save", [Controller::class, "postSaveChanges"]);
    Route::prefix("/{variation_id}")->group(function () {
        Route::delete("/", [Controller::class, "deleteVariation"]);
    });
});
