<?php

namespace App\Database\Models;

use App\Classes\Base\Database\Pivot;

class ProductPropertyX extends Pivot
{
    protected $table = 'products_properties';

    public function value()
    {
        return $this->belongsTo(PropertyValue::class, "property_value_id");
    }
}
