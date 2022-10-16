<?php

namespace App\Database\Seeders;



use App\Classes\Base\Database\Seeder;

class UndoFake extends Seeder
{
    public function run()
    {
        $this->call([
            UndoFakeProducts::class,
            UndoFakeCategoriesBrands::class,
            UndoFakeCategoriesAttributes::class,
            UndoFakeSpecificationGroup::class,
            UndoFakeProperties::class,
            UndoFakeAttributeValues::class,
            UndoFakeUser::class,
        ]);
    }
}
