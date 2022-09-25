<?php

use Illuminate\Support\Facades\Route;

use App\Http\Apps\Admin\Modules\Api\Controllers\Shop\Products\MainController as Controller;

Route::prefix("/{product_id}")->group(function () {
    Route::patch("/", [Controller::class, "patchProduct"]);
    Route::patch("/category", [Controller::class, "patchCategory"]);
});
