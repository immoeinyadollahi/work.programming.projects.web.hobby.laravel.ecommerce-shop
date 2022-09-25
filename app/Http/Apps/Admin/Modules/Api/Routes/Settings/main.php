<?php

use Illuminate\Support\Facades\Route;

use App\Http\Apps\Admin\Modules\Api\Controllers\Settings\MainController as Controller;

Route::post("/logo", [Controller::class, "postLogo"]);
