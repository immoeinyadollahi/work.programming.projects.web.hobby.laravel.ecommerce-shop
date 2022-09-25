<?php

namespace App\Database\Models;

use App\Classes\Base\Database\Pivot;

class ProductSale extends Pivot
{
    protected $table = 'products_sales';

    public function product()
    {
        return $this->belongsTo(Product::class, "product_id");
    }
    public function user()
    {
        return $this->belongsTo(User::class, "user_id");
    }
}
