<?php

namespace App\Database\Models;

use App\Classes\Base\Database\Model;

class ProductThumbnail extends Model
{
    protected $table = 'product_thumbnails';

    public function product()
    {
        return $this->belongsTo(Product::class, "product_id");
    }
}
