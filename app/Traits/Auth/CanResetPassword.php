<?php

namespace App\Traits\Auth;

use Illuminate\Support\Facades\Mail;

use App\Mail\UserResetPasswordMail;
use App\Database\Models\ResetPasswordToken;

trait CanResetPassword
{
    public function deleteResetPasswordToken()
    {
        ResetPasswordToken::where("email", $this->email)->_deleteFirst();
    }
    public function sendResetPasswordMail($reset_password_url_callback)
    {
        $this->deleteResetPasswordToken();
        $email = $this->email;
        $password_reset_token = ResetPasswordToken::createJwtToken(["email" => $email], 60 * 60)->token;
        Mail::to($email)->queue(new UserResetPasswordMail($email, $reset_password_url_callback($password_reset_token)));
    }
}
