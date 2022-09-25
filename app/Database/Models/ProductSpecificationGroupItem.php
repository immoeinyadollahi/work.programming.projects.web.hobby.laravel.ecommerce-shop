<?php

namespace App\Database\Models;

use App\Classes\Base\Database\Model;

class ProductSpecificationGroupItem extends Model
{
    protected $table = 'product_specification_group_items';

    public function group()
    {
        return $this->belongsTo(ProductSpecificationGroup::class, "group_id");
    }
}
