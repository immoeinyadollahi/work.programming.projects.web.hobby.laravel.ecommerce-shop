<?php

namespace App\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Database\Models\SpecificationItem;

class SpecificationItemFactory extends Factory
{
    protected $model = SpecificationItem::class;

    public function definition()
    {
        return [
            "name" => $this->faker->name()
        ];
    }
}
