<?php

namespace App\Database\Models;

use App\Classes\Base\Database\Model;
use App\Traits\Eloquent\Tokenable;

class PaymentRedirectionToken extends Model
{
    use Tokenable;

    protected $table = "payment_redirection_token";
    protected $casts = ["inputs" => "array"];
}
