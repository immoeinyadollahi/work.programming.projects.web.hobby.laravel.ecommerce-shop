<?php

namespace App\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Database\Models\ProductComment;

class ProductCommentFactory extends Factory
{
    protected $model = ProductComment::class;

    public function definition()
    {
        return [
            "rating" => $this->faker->numberBetween(0, 5),
            "text" => $this->faker->text(150),
            "is_verified" => true,
        ];
    }
}
