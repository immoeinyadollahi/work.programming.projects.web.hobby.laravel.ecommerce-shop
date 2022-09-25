<?php

namespace App\Database\Models;

use App\Classes\Base\Database\Model;

class ProductComment extends Model
{
    protected $table = 'product_comments';

    public function product()
    {
        return $this->belongsTo(Product::class, "product_id");
    }
    public function user()
    {
        return $this->belongsTo(User::class, "user_id");
    }
    public function engagedUsers()
    {
        return $this->morphToMany(User::class, "target", LikeDislike::class)->withTimestamps();
    }
}
