<?php

namespace App\Database\Models;

use App\Classes\Base\Database\Pivot;

class CategoryPropertyX extends Pivot
{
    protected $table = 'categories_properties';

    public function values()
    {
        return $this->belongsToMany(PropertyValue::class, CategoryPropertyXValue::class, "category_property_id")->withTimestamps();
    }
    public function category()
    {
        return $this->belongsTo(Category::class, "category_id");
    }
    public function property()
    {
        return $this->belongsTo(Property::class, "property_id");
    }
}
