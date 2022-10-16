<?php

namespace App\Database\Models;

use App\Classes\Base\Database\Pivot;

class ProductSpecificationX extends Pivot
{
    protected $table = 'products_specifications';

    public function items()
    {
        return $this->belongsToMany(SpecificationItem::class, ProductSpecificationXItemX::class, "product_specification_id")->withTimestamps();
    }
}
