<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;

class UserResetPasswordMail extends Mailable
{
    use Queueable;

    public function __construct($email, $reset_password_url)
    {
        $this->view('mail::user-reset-password', ["email" => $email, "reset_password_url" => $reset_password_url])->subject("فراموشی رمز عبور");
    }
    public function build()
    {
        return $this;
    }
}
