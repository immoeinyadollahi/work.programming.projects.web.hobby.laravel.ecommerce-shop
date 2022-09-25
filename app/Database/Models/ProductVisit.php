<?php

namespace App\Database\Models;

use App\Classes\Base\Database\Model;

class ProductVisit extends Model
{
    protected $table = 'product_visits';

    public function product()
    {
        return $this->belongsTo(Product::class, "product_id");
    }
}
