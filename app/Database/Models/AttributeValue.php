<?php

namespace App\Database\Models;

use App\Classes\Base\Database\Model;

class AttributeValue extends Model
{
    protected $table = 'attribute_values';
    protected $casts = ["meta" => "object"];

    public function attribute()
    {
        return $this->belongsTo(Attribute::class, "attribute_id");
    }
}
