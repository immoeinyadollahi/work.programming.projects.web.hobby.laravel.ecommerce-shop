<?php

namespace App\Database\Models;

use App\Classes\Base\Database\Pivot;

class VariableProductSuAttribute extends Pivot
{
    protected $table = 'variable_product_su_attributes';

    public function value()
    {
        return $this->belongsTo(AttributeValue::class, "attribute_value_id");
    }
}
