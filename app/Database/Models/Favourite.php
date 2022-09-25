<?php

namespace App\Database\Models;

use App\Classes\Base\Database\MorphPivot;

class Favourite extends MorphPivot
{
    protected $table = 'favourites';
}
