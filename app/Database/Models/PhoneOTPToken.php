<?php

namespace App\Database\Models;

use App\Classes\Base\Database\Model;
use App\Traits\Eloquent\Tokenable;

class PhoneOTPToken extends Model
{
    use Tokenable;

    protected $table = 'phone_otp_tokens';
}
