<?php

namespace App\Database\Models;

use App\Classes\Base\Database\Model;

class Property extends Model
{
    protected $table = 'properties';

    public function values()
    {
        return $this->hasMany(PropertyValue::class, "property_id");
    }
}
