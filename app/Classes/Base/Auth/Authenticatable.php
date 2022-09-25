<?php

namespace App\Classes\Base\Auth;

use Illuminate\Foundation\Auth\User as IlluminateAuthenticatable;

use App\Traits\Eloquent\ModelExtraMethods;
use App\Traits\Auth\CanResetPassword;
use App\Traits\Auth\MustVerifyEmail;

class Authenticatable extends IlluminateAuthenticatable
{
    use ModelExtraMethods, CanResetPassword, MustVerifyEmail;

    protected $guarded = [];
}
