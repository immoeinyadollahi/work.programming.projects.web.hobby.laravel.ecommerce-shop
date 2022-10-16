<?php

namespace App\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Database\Models\SpecificationItem;

class SpecificationItemFactory extends Factory
{
    protected $model = SpecificationItem::class;

    public function definition()
    {
        $value_type = $this->faker->randomElement(["text", "boolean"]);
        return [
            "name" => $this->faker->name(),
            "value" => $value_type === "boolean" ? $this->faker->boolean() : $this->faker->words(3, true),
            "value_type" => $value_type
        ];
    }
}
