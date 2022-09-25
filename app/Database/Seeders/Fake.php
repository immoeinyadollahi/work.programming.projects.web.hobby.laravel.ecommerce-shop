<?php

namespace App\Database\Seeders;

use App\Classes\Base\Database\Seeder;

class Fake extends Seeder
{
    public function run()
    {
        $this->call([
            FakeUser::class,
            FakeAttributeValues::class,
            FakeProperties::class,
            FakeCategoriesProperties::class,
            FakeCategoriesAttributes::class,
            FakeCategoriesBrands::class,
            FakeComparableCategories::class,
            FakeProducts::class,
        ]);
    }
}
