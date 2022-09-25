<?php

namespace App\Database\Models;

use App\Classes\Base\Database\Model;

class Image extends Model
{
    protected $table = 'images';

    public function target()
    {
        return $this->morphTo();
    }
}
