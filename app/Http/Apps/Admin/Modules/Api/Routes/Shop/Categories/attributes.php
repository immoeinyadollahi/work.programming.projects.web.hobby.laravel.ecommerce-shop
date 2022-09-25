<?php

use Illuminate\Support\Facades\Route;

use App\Http\Apps\Admin\Modules\Api\Controllers\Shop\Categories\AttributesController as Controller;

Route::prefix("/{category_id}")->group(function () {
    Route::post("/attributes/save", [Controller::class, "postSaveAttributes"]);
});
Route::post("/attributes/{attribute_id}/values/save", [Controller::class, "postSaveAttributeValues"]);
