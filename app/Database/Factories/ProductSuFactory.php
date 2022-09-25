<?php

namespace App\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Database\Models\ProductSu;

class ProductSuFactory extends Factory
{
    protected $model = ProductSu::class;

    public function definition()
    {
        $price = $this->faker->numberBetween(500, 10000);
        $discounted_price = null;
        $discount_expire = null;
        $has_discount = $this->faker->boolean();
        if ($has_discount) {
            $discounted_price = $this->faker->numberBetween(400, $price);
            if ($this->faker->boolean()) {
                $discount_expire = now()->addDays($this->faker->numberBetween(1, 10));
            }
        }
        $price *= 1000;
        $discounted_price && ($discounted_price *= 1000);
        $discount_price = $discounted_price ? $price - $discounted_price : null;
        return [
            "product_type" => $this->faker->randomElement(["simple", "variable"]),
            "price" => $price,
            "sale_price" => $discounted_price ?: $price,
            "discounted_price" => $discounted_price,
            "discount_price" => $discount_price,
            "discount_percent" => $discount_price ? $discount_price * 100 / $price   : null,
            "discount_expire" => $discount_expire,
            "stock" => $this->faker->numberBetween(1, 20),
            "description" => $this->faker->text(),
            "is_active" => true
        ];
    }
}
