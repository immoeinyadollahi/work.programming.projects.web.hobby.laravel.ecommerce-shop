<?php

namespace App\Database\Models;

use App\Classes\Base\Database\Model;

class Province extends Model
{
    protected $table = 'provinces';

    public function addresses()
    {
        return $this->hasMany(Address::class, "province_id");
    }
    public function cities()
    {
        return $this->hasMany(City::class, "province_id");
    }
}
