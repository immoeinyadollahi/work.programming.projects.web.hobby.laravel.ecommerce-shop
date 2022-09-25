<?php

namespace App\Database\Models;

use App\Classes\Base\Database\Model;
use App\Traits\Eloquent\Tokenable;

class EmailVerificationToken extends Model
{
    use Tokenable;

    protected $table = 'email_verification_tokens';
}
