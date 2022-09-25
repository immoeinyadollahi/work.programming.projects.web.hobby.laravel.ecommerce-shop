<?php

namespace App\Database\Models;

use App\Classes\Base\Database\Model;

class City extends Model
{
    protected $table = 'cities';

    public function addresses()
    {
        return $this->hasMany(Address::class, "city_id");
    }
    public function province()
    {
        return $this->belongsTo(Province::class, "province_id");
    }
}
