<?php

namespace App\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Database\Models\Product;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            "type" => $this->faker->randomElement(["simple", "variable"]),
            "status" => $this->faker->randomElement(['draft', 'published']),
            "name" => $this->faker->name(),
            "slug" => $this->faker->slug(2),
            "description" => $this->faker->text()
        ];
    }
}
