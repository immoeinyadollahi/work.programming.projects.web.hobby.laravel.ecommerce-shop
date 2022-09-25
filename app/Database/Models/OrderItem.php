<?php

namespace App\Database\Models;

use Illuminate\Database\Eloquent\Casts\Attribute as CastAttribute;

use App\Classes\Base\Database\Model;

class OrderItem extends Model
{
    protected $table = 'order_items';
    protected $appends = ['product_su_sale_price'];

    public function order()
    {
        return $this->belongsTo(Order::class, "order_id");
    }
    public function productSu()
    {
        return $this->belongsTo(ProductSu::class, "product_su_id");
    }

    protected function productSuSalePrice(): CastAttribute
    {
        return CastAttribute::get(fn () => $this->product_su_discounted_price ?: $this->product_su_price);
    }
}
