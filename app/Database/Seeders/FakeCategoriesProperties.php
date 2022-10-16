<?php

namespace App\Database\Seeders;

use App\Classes\Base\Database\Seeder;
use App\Database\Models\PropertyGroup;
use App\Database\Models\Category;

class FakeCategoriesProperties extends Seeder
{
    public function run()
    {
        $category = Category::where("en", "shirts")->first();
        $property_group = PropertyGroup::first();
        $category->update(["property_group_id" => $property_group->id]);
        foreach ($property_group->properties()->get() as $key => $property) {
            $category->properties()->attach($property->id, ["order" => $key + 1]);
        }
        foreach ($category->properties()->get() as $property) {
            foreach ($property->values()->inRandomOrder()->limit(rand(1, 10))->get() as $key => $value) {
                $property->pivot->values()->attach($value->id, ["order" => $key + 1]);
            }
        }
    }
}
