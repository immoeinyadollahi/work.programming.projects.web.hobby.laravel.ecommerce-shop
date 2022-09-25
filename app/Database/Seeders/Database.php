<?php

namespace App\Database\Seeders;

use App\Classes\Base\Database\Seeder;

class Database extends Seeder
{
    public function run()
    {
        $this->call([
            Categories::class,
            Brands::class,
            Roles::class,
            Locations::class,
            Attributes::class,
        ]);
    }
}
