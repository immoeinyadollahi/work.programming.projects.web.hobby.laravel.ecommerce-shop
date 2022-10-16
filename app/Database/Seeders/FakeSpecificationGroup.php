<?php

namespace App\Database\Seeders;

use App\Classes\Base\Database\Seeder;
use App\Database\Factories\SpecificationGroupFactory;
use App\Database\Factories\SpecificationFactory;
use App\Database\Factories\SpecificationItemFactory;

class FakeSpecificationGroup extends Seeder
{
    public function run()
    {
        $group = SpecificationGroupFactory::new()->create(['name' => 'تیشرت']);
        $group_specifications = SpecificationFactory::times(rand(2, 5))->make(['group_id' => $group->id]);
        foreach ($group_specifications as $key => $specification) {
            $specification->fill(['order' => $key + 1])->save();
            $items = SpecificationItemFactory::times(rand(5, 9))->make(["specification_id" => $specification->id]);
            foreach ($items as $key => $item) {
                $item->fill(['order' => $key + 1])->save();
            }
        }
    }
}
