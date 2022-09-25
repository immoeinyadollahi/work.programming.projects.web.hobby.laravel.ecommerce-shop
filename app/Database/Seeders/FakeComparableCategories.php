<?php

namespace App\Database\Seeders;

use BenTools\CartesianProduct\CartesianProduct;

use App\Classes\Base\Database\Seeder;
use App\Database\Models\Category;
use App\Database\Models\ComparableCategory;

class FakeComparableCategories extends Seeder
{
    public function run()
    {
        $categories = Category::whereHas("parent", function ($query) {
            $query->where("en", "mobile-phone");
        })->pluck("id");

        $comparable_combinations = new CartesianProduct([$categories, $categories]);
        foreach ($comparable_combinations as $combination) {
            ComparableCategory::create(["category_id_1" => $combination[0], "category_id_2" => $combination[1]]);
        }
    }
}
