<?php

namespace App\Database\Models;

use App\Classes\Base\Database\Pivot;

class CategorySpecificationX extends Pivot
{
    protected $table = 'categories_specifications';

    public function items()
    {
        return $this->belongsToMany(SpecificationItem::class, CategorySpecificationXItemX::class, "category_specification_id")->withTimestamps();
    }
}
