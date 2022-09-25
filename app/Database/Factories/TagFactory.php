<?php

namespace App\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Database\Models\Tag;

class TagFactory extends Factory
{
    protected $model = Tag::class;

    public function definition()
    {
        return [
            "name" => $this->faker->name(),
            "slug" => $this->faker->slug(1),
        ];
    }
}
