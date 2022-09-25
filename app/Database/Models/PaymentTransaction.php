<?php

namespace App\Database\Models;

use App\Classes\Base\Database\Model;

class PaymentTransaction extends Model
{
    protected $table = 'payment_transactions';

    public function order()
    {
        return $this->belongsTo(Order::class, "order_id");
    }
}
