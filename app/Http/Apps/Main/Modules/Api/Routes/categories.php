<?php

use Illuminate\Support\Facades\Route;

use App\Http\Apps\Main\Modules\Api\Controllers\CategoriesController as Controller;

Route::get("/categories/{category_id}/products", [Controller::class, "getProducts"]);
