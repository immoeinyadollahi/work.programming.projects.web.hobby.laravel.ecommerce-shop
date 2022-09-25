<?php

namespace App\Database\Models;

use App\Classes\Base\Database\Model;

class Address extends Model
{
    protected $table = 'addresses';

    public function user()
    {
        return $this->belongsTo(User::class, "user_id");
    }
    public function orders()
    {
        return $this->hasMany(Order::class, "address_id");
    }
    public function province()
    {
        return $this->belongsTo(Province::class, "province_id");
    }
    public function city()
    {
        return $this->belongsTo(City::class, "city_id");
    }
}
