<?php

namespace App\Database\Models;

use App\Classes\Base\Database\Model;

class ProductWarranty extends Model
{
    protected $table = 'product_warranties';

    public function su()
    {
        return $this->hasMany(ProductSu::class, "warranty_id");
    }
}
