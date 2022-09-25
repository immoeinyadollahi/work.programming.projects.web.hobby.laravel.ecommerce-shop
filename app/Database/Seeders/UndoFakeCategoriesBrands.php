<?php

namespace App\Database\Seeders;

use App\Classes\Base\Database\Seeder;
use App\Database\Models\CategoryBrandX;

class UndoFakeCategoriesBrands extends Seeder
{
    public function run()
    {
        CategoryBrandX::delete();
    }
}
