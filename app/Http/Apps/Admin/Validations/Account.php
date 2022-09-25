<?php

namespace App\Http\Apps\Admin\Validations;

use App\Classes\Validation\Validation;

class Account extends Validation
{
    protected static function login($data)
    {
        return [
            [
                'email' => 'required|email',
                'password' => 'required'
            ],
            [
                "email.required" => "ایمیل الزامی است",
                "email.email" => "ایمیل وارد شده صحیح نیست",
                "password.required" => "کلمه عبور الزامی است"
            ]
        ];
    }
}
