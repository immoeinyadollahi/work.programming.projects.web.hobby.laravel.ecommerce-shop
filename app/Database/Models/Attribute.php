<?php

namespace App\Database\Models;

use App\Classes\Base\Database\Model;

class Attribute extends Model
{
    protected $table = 'attributes';
    protected $casts = ["is_custom" => "boolean"];

    public function values()
    {
        return $this->hasMany(AttributeValue::class, "attribute_id");
    }
}
