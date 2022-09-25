<?php

namespace App\Database\Models;

use App\Classes\Base\Database\Pivot;

class CategoryAttributeX extends Pivot
{
    protected $table = 'categories_attributes';

    public function values()
    {
        return $this->belongsToMany(AttributeValue::class, CategoryAttributeXValue::class, "category_attribute_id")->withTimestamps();
    }
    public function category()
    {
        return $this->belongsTo(Category::class, "category_id");
    }
    public function attribute()
    {
        return $this->belongsTo(Attribute::class, "attribute_id");
    }
}
