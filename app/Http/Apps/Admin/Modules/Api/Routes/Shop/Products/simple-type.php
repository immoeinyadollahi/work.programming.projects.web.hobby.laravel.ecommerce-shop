<?php

use Illuminate\Support\Facades\Route;

use App\Http\Apps\Admin\Modules\Api\Controllers\Shop\Products\SimpleTypeController as Controller;

Route::prefix("/{product_id}")->group(function () {
    Route::patch("/simple-type/su", [Controller::class, "patchSu"]);
});
