<?php

use Illuminate\Support\Facades\Route;

use App\Http\Apps\Admin\Modules\Web\Controllers\Shop\CategoriesController as Controller;

Route::prefix("/categories")->group(function () {
    Route::get("/", [Controller::class, "getCategories"]);
    Route::get("/create", [Controller::class, "getCreateCategory"]);
});
Route::prefix("/category/{category_id}")->group(function () {
    Route::post("/edit", [Controller::class, "postEditCategory"]);
    Route::get("/edit", [Controller::class, "getEditCategory"]);
    Route::get("/delete", [Controller::class, "getDeleteCategory"]);
});
