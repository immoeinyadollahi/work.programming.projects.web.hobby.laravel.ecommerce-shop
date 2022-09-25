<?php

use Illuminate\Support\Facades\Route;

use App\Http\Apps\Admin\Modules\Api\Controllers\Shop\Categories\MediaController as Controller;

Route::post("/image", [Controller::class, "postImage"]);
