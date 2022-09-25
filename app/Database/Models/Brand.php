<?php

namespace App\Database\Models;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

use App\Classes\Base\Database\Model;

class Brand extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $table = 'brands';

    public function products()
    {
        return $this->hasMany(Product::class, "brand_id")->withTimestamps();
    }
    public function image()
    {
        return $this->morphOne(Image::class, 'target');
    }
}
