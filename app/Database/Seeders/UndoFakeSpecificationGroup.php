<?php

namespace App\Database\Seeders;

use App\Classes\Base\Database\Seeder;
use App\Database\Models\SpecificationGroup;

class UndoFakeSpecificationGroup extends Seeder
{
    public function run()
    {
        SpecificationGroup::delete();
    }
}
