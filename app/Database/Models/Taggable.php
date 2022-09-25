<?php

namespace App\Database\Models;

use App\Classes\Base\Database\MorphPivot;

class Taggable extends MorphPivot
{
    protected $table = 'taggables';
}
