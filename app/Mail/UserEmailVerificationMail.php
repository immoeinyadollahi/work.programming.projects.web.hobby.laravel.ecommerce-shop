<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;

class UserEmailVerificationMail extends Mailable
{
    use Queueable;

    public function __construct($email, $verify_url)
    {
        $this->view('mail::user-email-verification', ["email" => $email, "verify_url" => $verify_url])->subject("ثبت نام");
    }
    public function build()
    {
        return $this;
    }
}
