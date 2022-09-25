<?php

namespace App\Database\Models;

use App\Classes\Base\Auth\Authenticatable;
use App\Traits\Spatie\HasRoles;

class User extends Authenticatable
{
    use HasRoles;

    protected $table = 'users';

    public function profileImage()
    {
        return $this->morphOne(Image::class, 'target');
    }
    public function favoredProducts()
    {
        return $this->morphedByMany(Product::class, 'target', Favourite::class)->withTimestamps();
    }
    public function productComments()
    {
        return $this->hasMany(ProductComment::class, "user_id");
    }
    public function engagedProductComments()
    {
        return $this->morphedByMany(ProductComment::class, "target", LikeDislike::class)->withTimestamps();
    }
    public function addresses()
    {
        return $this->hasMany(Address::class, "user_id");
    }
    public function orders()
    {
        return $this->hasMany(Order::class, "user_id");
    }
    public function cart()
    {
        return $this->hasOne(Cart::class, "user_id");
    }
}
