<?php

namespace App\Database\Seeders;

use App\Classes\Base\Database\Seeder;
use App\Database\Models\SpecificationGroup;
use App\Database\Models\Category;

class FakeCategoriesSpecifications extends Seeder
{
    public function run()
    {
        $category = Category::where("en", "shirts")->first();
        $specification_group = SpecificationGroup::first();
        $category->update(["specification_group_id" => $specification_group->id]);
        foreach ($specification_group->specifications()->_ordered()->get() as $key => $specification) {
            $category->specifications()->attach($specification->id, ["order" => $key + 1]);
        }
        foreach ($category->specifications()->get() as $specification) {
            foreach ($specification->items()->inRandomOrder()->limit(rand(1, 10))->get() as $key => $item) {
                $specification->pivot->items()->attach($item->id, ["order" => $key + 1]);
            }
        }
    }
}
