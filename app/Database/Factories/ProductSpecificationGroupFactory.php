<?php

namespace App\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Database\Models\ProductSpecificationGroup;

class ProductSpecificationGroupFactory extends Factory
{
    protected $model = ProductSpecificationGroup::class;

    public function definition()
    {
        return [
            "name" => $this->faker->name(),
        ];
    }
}
