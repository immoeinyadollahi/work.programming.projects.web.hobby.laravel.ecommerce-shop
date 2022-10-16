<?php

namespace App\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Database\Models\SpecificationGroup;

class SpecificationGroupFactory extends Factory
{
    protected $model = SpecificationGroup::class;

    public function definition()
    {
        return [
            "name" => $this->faker->name(),
        ];
    }
}
