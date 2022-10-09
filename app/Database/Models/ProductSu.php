<?php

namespace App\Database\Models;

use App\Classes\Base\Database\Model;

class ProductSu extends Model
{
    protected $table = 'products_su';

    public function product()
    {
        return $this->belongsTo(Product::class, "product_id");
    }
    public function warranty()
    {
        return $this->belongsTo(ProductWarranty::class, "warranty_id");
    }
    public function cartItems()
    {
        return $this->hasMany(CartItem::class, "product_su_id");
    }
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, "product_su_id");
    }
    public function variableProductTypeAttributes()
    {
        return $this->belongsToMany(Attribute::class, VariableProductSuAttribute::class)->withTimestamps()->withPivot(["id", "order", "attribute_value_id"]);
    }

    public function scopeActive($query)
    {
        return $query->where("is_active", true);
    }
    public function scopeInStock($query)
    {
        return $query->where("stock", "!=", 0);
    }
}
