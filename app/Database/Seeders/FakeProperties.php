<?php

namespace App\Database\Seeders;

use App\Classes\Base\Database\Seeder;
use App\Database\Models\PropertyGroup;

class FakeProperties extends Seeder
{
    public function run()
    {
        foreach (range(0, 4) as $value) {
            $group = PropertyGroup::create(["name" => $this->faker->name()]);
            foreach (range(0, 9) as $value) {
                $property = $group->properties()->create(["name" => $this->faker->name(), "is_comparable" => rand(0, 1)]);
                foreach (range(0, 9) as $value) {
                    $property->values()->create(["value" => $this->faker->word()]);
                }
            }
        }
    }
}
