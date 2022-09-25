<?php

namespace App\Database\Seeders;

use App\Classes\Base\Database\Seeder;
use App\Database\Models\ComparableCategory;

class UndoFakeComparableCategories extends Seeder
{
    public function run()
    {
        ComparableCategory::delete();
    }
}
