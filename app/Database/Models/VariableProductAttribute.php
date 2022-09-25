<?php

namespace App\Database\Models;

use App\Classes\Base\Database\Pivot;

class VariableProductAttribute extends Pivot
{
    protected $table = 'variable_product_attributes';

    public function values()
    {
        return $this->belongsToMany(AttributeValue::class, VariableProductAttributeValue::class, "variable_product_attribute_id")->withTimestamps();
    }
    public function product()
    {
        return $this->belongsTo(Product::class, "product_id");
    }
    public function attribute()
    {
        return $this->belongsTo(Attribute::class, "attribute_id");
    }
}
