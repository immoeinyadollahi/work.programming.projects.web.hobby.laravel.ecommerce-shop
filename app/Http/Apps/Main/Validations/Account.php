<?php

namespace App\Http\Apps\Main\Validations;

use App\Classes\Validation\Validation;

class Account extends Validation
{
    protected static function register($data)
    {
        return [
            [
                'fullname' => 'required|min:4',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:4|max:255',
                'confirm_password' => 'required|same:password'
            ],
            [
                "fullname.required" => "نام و نام خانوادگی الزامی است",
                "fullname.min" => "نام و نام خانوادگی نمیتواند کمتر از 2 کاراکتر باشد",
                "email.required" => "ایمیل الزامی است",
                "email.email" => "ایمیل وارد شده صحیح نیست",
                "email.unique" => "کاربری با این ایمیل موجود است",
                "password.required" => "کلمه عبور الزامی است",
                "password.min" => "کلمه عبور نمیتواند کمتر از 2 کاراکتر باشد",
                "password.max" => "کلمه عبور باید کمتر از 255 کاراکتر باشد",
                "confirm_password.required" => "تکرار رمز عبور الزامی است",
                "confirm_password.same" => "رمز عبور با تکرار رمز عبور یکسان نیست",
            ]
        ];
    }
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
    protected static function forgetPassword($data)
    {
        return [
            [
                'email' => 'required|email',
            ],
            [
                "email.required" => "ایمیل الزامی است",
                "email.email" => "ایمیل وارد شده صحیح نیست",
            ]
        ];
    }
    protected static function resetPassword($data)
    {
        return [
            [
                'password' => 'required|min:4|max:255',
                'confirm_password' => 'required|same:password'
            ],
            [
                "password.required" => "کلمه عبور الزامی است",
                "password.min" => "کلمه عبور نمیتواند کمتر از 2 کاراکتر باشد",
                "password.max" => "کلمه عبور باید کمتر از 255 کاراکتر باشد",
                "confirm_password.required" => "تکرار رمز عبور الزامی است",
                "confirm_password.same" => "رمز عبور با تکرار رمز عبور یکسان نیست",
            ]
        ];
    }
}
