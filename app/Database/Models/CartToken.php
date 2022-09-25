<?php

namespace App\Database\Models;

use App\Classes\Base\Database\Model;
use App\Traits\Eloquent\Tokenable;

class CartToken extends Model
{
    use Tokenable;

    protected $table = 'cart_tokens';
}
