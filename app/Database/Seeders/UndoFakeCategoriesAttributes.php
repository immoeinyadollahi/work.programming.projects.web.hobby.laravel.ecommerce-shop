<?php

namespace App\Database\Seeders;

use App\Classes\Base\Database\Seeder;
use App\Database\Models\CategoryAttributeX;

class UndoFakeCategoriesAttributes extends Seeder
{
    public function run()
    {
        CategoryAttributeX::delete();
    }
}
