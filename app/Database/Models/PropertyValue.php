<?php

namespace App\Database\Models;

use App\Classes\Base\Database\Model;

class PropertyValue extends Model
{
    protected $table = 'property_values';

    public function property()
    {
        return $this->belongsTo(Property::class, "property_id");
    }
}
