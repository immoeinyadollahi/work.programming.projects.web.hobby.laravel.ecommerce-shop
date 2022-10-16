<?php

namespace App\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Database\Models\Specification;

class SpecificationFactory extends Factory
{
    protected $model = Specification::class;

    public function definition()
    {
        return [
            "name" => $this->faker->name(),
        ];
    }
}
