<?php

namespace App\Database\Seeders;

use App\Classes\Base\Database\Seeder;
use App\Database\Models\Attribute;
use App\Database\Models\Category;

class FakeCategoriesAttributes extends Seeder
{
    public function run()
    {
        $category = Category::where("en", "shirts")->first();
        $attributes = Attribute::all();
        foreach ($attributes as $key => $attribute) {
            $category->attributes()->attach($attribute->id, ["order" => $key + 1]);
        }
        foreach ($category->attributes()->get() as $key => $attribute) {
            foreach ($attribute->values()->inRandomOrder()->get() as $key => $value) {
                $attribute->pivot->values()->attach($value->id, ["order" => $key + 1]);
            }
        }
    }
}
