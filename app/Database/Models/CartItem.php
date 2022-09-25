<?php

namespace App\Database\Models;

use App\Classes\Base\Database\Model;

class CartItem extends Model
{
    protected $table = 'cart_items';

    public function cart()
    {
        return $this->belongsTo(Cart::class, "cart_id");
    }
    public function productSu()
    {
        return $this->belongsTo(ProductSu::class, "product_su_id");
    }
}
