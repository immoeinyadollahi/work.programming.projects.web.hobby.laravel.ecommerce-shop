<?php

namespace App\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Database\Models\Address;

class AddressFactory extends Factory
{
    protected $model = Address::class;

    public function definition()
    {
        return [
            "recipient_fullname" => $this->faker->name(),
            "recipient_email" => $this->faker->email(),
            "recipient_phone" => $this->faker->phoneNumber(),
            "postal_address" => $this->faker->address(),
            "postal_code" => $this->faker->postcode(),
        ];
    }
}
