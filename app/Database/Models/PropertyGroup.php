<?php

namespace App\Database\Models;

use App\Classes\Base\Database\Model;

class PropertyGroup extends Model
{
    protected $table = 'property_groups';

    public function properties()
    {
        return $this->hasMany(Property::class, "group_id");
    }
}
