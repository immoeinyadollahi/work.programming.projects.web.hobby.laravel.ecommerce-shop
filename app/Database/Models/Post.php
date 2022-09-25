<?php

namespace App\Database\Models;

use App\Classes\Base\Database\Model;

class Post extends Model
{
    protected $table = 'posts';

    public function image()
    {
        return $this->morphOne(Image::class, 'target');
    }
}
