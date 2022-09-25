<?php

use Illuminate\Support\Facades\Route;

use App\Http\Apps\Admin\Modules\Api\Controllers\Shop\Products\MediaController as Controller;

Route::post("/image", [Controller::class, "postImage"]);
Route::post("/thumbnails", [Controller::class, "postThumbnail"]);
