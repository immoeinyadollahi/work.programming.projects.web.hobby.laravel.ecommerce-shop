<?php

namespace App\Database\Models;

use App\Classes\Base\Database\Model;

class Tag extends Model
{
    protected $table = 'tags';

    public function products()
    {
        return $this->morphedByMany(Product::class, "target", Taggable::class)->withTimestamps();
    }
}
