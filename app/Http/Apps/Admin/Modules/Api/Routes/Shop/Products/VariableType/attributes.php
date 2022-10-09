<?php

use Illuminate\Support\Facades\Route;

use App\Http\Apps\Admin\Modules\Api\Controllers\Shop\Products\VariableType\AttributesController as Controller;

Route::prefix("/{product_id}/variable-type/attributes")->group(function () {
    Route::post("/", [Controller::class, "postAttribute"]);
    Route::post("/save", [Controller::class, "postSaveOrdering"]);
    Route::prefix("/{attribute_id}")->group(function () {
        Route::delete("/", [Controller::class, "deleteAttribute"]);
        Route::patch("/values", [Controller::class, "patchValues"]);
    });
});
