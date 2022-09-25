<?php

use Illuminate\Support\Facades\Route;

use App\Http\Apps\Admin\Modules\Api\Controllers\Shop\Properties\MainController as Controller;

Route::patch("/property-groups/with-properties", [Controller::class, "getGroupsWithProperties"]);
