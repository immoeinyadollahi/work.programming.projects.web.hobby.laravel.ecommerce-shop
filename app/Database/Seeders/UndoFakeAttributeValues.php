<?php

namespace App\Database\Seeders;

use App\Classes\Base\Database\Seeder;
use App\Database\Models\AttributeValue;

class UndoFakeAttributeValues extends Seeder
{
    public function run()
    {
        AttributeValue::delete();
    }
}
