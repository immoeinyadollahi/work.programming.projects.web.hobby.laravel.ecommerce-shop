<?php

namespace App\Database\Seeders;

use App\Classes\Base\Database\Seeder;
use App\Database\Models\Brand;
use App\Database\Models\Category;

class FakeCategoriesBrands extends Seeder
{
    public function run()
    {
        $category = Category::where("en", "shirts")->first();
        $brands = Brand::all();
        foreach ($brands as $key => $brand) {
            $category->brands()->attach($brand->id, ["order" => $key + 1]);
        }
    }
}
