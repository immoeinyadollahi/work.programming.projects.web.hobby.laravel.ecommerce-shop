<?php

namespace App\Database\Models;

use App\Classes\Base\Database\Model;

class OrderAddress extends Model
{
    protected $table = 'order_addresses';

    public function order()
    {
        return $this->belongsTo(Order::class, "order_id");
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
