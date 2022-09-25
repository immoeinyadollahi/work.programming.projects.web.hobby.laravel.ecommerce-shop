<?php

namespace App\Database\Models;

use App\Classes\Base\Database\MorphPivot;

class LikeDislike extends MorphPivot
{
    protected $table = 'likes_dislikes';
}
