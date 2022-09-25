<?php

namespace App\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Database\Models\ProductSpecificationGroupItem;

class ProductSpecificationGroupItemFactory extends Factory
{
    protected $model = ProductSpecificationGroupItem::class;

    public function definition()
    {
        $type = $this->faker->randomElement(["text", "boolean"]);
        return [
            "name" => $this->faker->name(),
            "value" => $type === "boolean" ? $this->faker->boolean() : $this->faker->words(3, true),
            "type" => $type
        ];
    }
}
