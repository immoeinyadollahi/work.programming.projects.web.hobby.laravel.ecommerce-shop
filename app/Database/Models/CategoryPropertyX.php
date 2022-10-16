<?php

namespace App\Database\Models;

use App\Classes\Base\Database\Pivot;

class CategoryPropertyX extends Pivot
{
    protected $table = 'categories_properties';

    public function values()
    {
        return $this->belongsToMany(PropertyValue::class, CategoryPropertyXValueX::class, "category_property_id")->withTimestamps();
    }
}
