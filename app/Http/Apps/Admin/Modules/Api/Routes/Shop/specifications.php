<?php

use Illuminate\Support\Facades\Route;

use App\Http\Apps\Admin\Modules\Api\Controllers\Shop\Specifications\MainController as Controller;

Route::prefix("/specification-groups")->group(function () {
    Route::get("/search", [Controller::class, "getSearchGroups"]);
    Route::get('{group_id}/specifications', [Controller::class, "getGroupSpecifications"]);
});
