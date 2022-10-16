<?php

namespace App\Database\Models;

use App\Classes\Base\Database\Model;

class Specification extends Model
{
    protected $table = 'specifications';

    public function items()
    {
        return $this->hasMany(SpecificationItem::class, "specification_id");
    }
}
