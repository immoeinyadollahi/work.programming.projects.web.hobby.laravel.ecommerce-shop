<?php

namespace App\Database\Seeders;

use App\Classes\Base\Database\Seeder;
use App\Database\Models\CategorySpecificationX;

class UndoFakeCategoriesSpecifications extends Seeder
{
    public function run()
    {
        CategorySpecificationX::delete();
    }
}
