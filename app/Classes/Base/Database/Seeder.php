<?php

namespace App\Classes\Base\Database;

use Faker\Generator as FakerGenerator;
use Illuminate\Database\Seeder as IlluminateSeeder;

class Seeder extends IlluminateSeeder
{
    /**
     * @var FakerGenerator
     */
    protected $faker;

    public function __construct()
    {
        $this->faker = app(FakerGenerator::class);
    }
}
