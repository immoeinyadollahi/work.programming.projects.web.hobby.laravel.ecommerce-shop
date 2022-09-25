<?php

namespace App\Traits\Auth;

use Illuminate\Support\Facades\Mail;

use App\Mail\UserEmailVerificationMail;
use App\Database\Models\EmailVerificationToken;

trait MustVerifyEmail
{
    public function unmarkVerifiedEmail()
    {
        $this->email_verified_at = null;
    }
    public function markEmailAsVerified()
    {
        $this->email_verified_at = now();
    }
    public function deleteEmailVerificationMail()
    {
        EmailVerificationToken::where("email", $this->email)->_deleteFirst();
    }
    public function sendEmailVerificationMail($verify_url_callback)
    {
        $this->deleteEmailVerificationMail();
        $email = $this->email;
        $email_verification_token = EmailVerificationToken::createJwtToken(["email" => $email], 60 * 60 * 24)->token;
        Mail::to($email)->queue(new UserEmailVerificationMail($email, $verify_url_callback($email_verification_token)));
    }
}
