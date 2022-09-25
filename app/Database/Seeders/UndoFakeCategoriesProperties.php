<?php

namespace App\Database\Seeders;

use App\Classes\Base\Database\Seeder;
use App\Database\Models\CategoryPropertyX;

class UndoFakeCategoriesProperties extends Seeder
{
    public function run()
    {
        CategoryPropertyX::delete();
    }
}
