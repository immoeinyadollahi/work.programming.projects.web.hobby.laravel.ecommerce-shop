<?php

namespace App\Database\Models;

use App\Classes\Base\Database\Pivot;

class CategoryAttributeX extends Pivot
{
    protected $table = 'categories_attributes';

    public function values()
    {
        return $this->belongsToMany(AttributeValue::class, CategoryAttributeXValueX::class, "category_attribute_id")->withTimestamps();
    }
}
