<?php

namespace App\Database\Models;

use App\Classes\Base\Database\Model;
use App\Traits\Eloquent\Tokenable;

class ResetPasswordToken extends Model
{
    use Tokenable;

    protected $table = 'reset_password_tokens';
}
