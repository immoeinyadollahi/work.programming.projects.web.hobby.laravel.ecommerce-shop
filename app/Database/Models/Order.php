<?php

namespace App\Database\Models;

use Illuminate\Database\Eloquent\Casts\Attribute as CastAttribute;

use App\Classes\Base\Database\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $appends = ['status_fa'];
    protected $casts = ['info' => 'object'];

    public function user()
    {
        return $this->belongsTo(User::class, "user_id");
    }
    public function address()
    {
        return $this->hasOne(OrderAddress::class, "order_id");
    }
    public function items()
    {
        return $this->hasMany(OrderItem::class, "order_id");
    }
    public function transactions()
    {
        return $this->hasMany(PaymentTransaction::class, "order_id");
    }

    protected function statusFa(): CastAttribute
    {
        return CastAttribute::get(function () {
            switch ($this->status) {
                case "delivered":
                    return "تحویل داده شده";
                case "canceled":
                    return "لغو شده";
                case "pending":
                    return "در انتظار پرداخت";
                case "returned":
                    return "مرجوع شده";
                case "processing":
                    return "در حال پردازش";
            }
        });
    }
}
