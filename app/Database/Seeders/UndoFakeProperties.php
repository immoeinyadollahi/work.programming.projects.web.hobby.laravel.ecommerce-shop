<?php

namespace App\Database\Seeders;

use App\Classes\Base\Database\Seeder;
use App\Database\Models\PropertyGroup;

class UndoFakeProperties extends Seeder
{
    public function run()
    {
        PropertyGroup::delete();
    }
}
