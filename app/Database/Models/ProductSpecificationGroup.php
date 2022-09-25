<?php

namespace App\Database\Models;

use App\Classes\Base\Database\Model;

class ProductSpecificationGroup extends Model
{
    protected $table = 'product_specification_groups';

    public function product()
    {
        return $this->belongsTo(Product::class, "product_id");
    }
    public function items()
    {
        return $this->hasMany(ProductSpecificationGroupItem::class, "group_id");
    }
}
