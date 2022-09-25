<?php

namespace App\Http\Apps\Main\Validations;

use App\Classes\Validation\Validation;

class Users extends Validation
{
    protected static function changePassword($data)
    {
        return [
            [
                'current_password' => 'required|current_password',
                'password' => 'required|min:4|max:255',
                'confirm_password' => 'required|same:password'
            ],
            [
                "current_password.required" => "کلمه عبور فعلی الزامی است",
                "current_password.current_password" => "کلمه عبور فعلی اشتباه است",
                "password.required" => "کلمه عبور جدید الزامی است",
                "password.min" => "کلمه عبور جدید نمیتواند کمتر از 2 کاراکتر باشد",
                "password.max" => "کلمه عبور جدید باید کمتر از 255 کاراکتر باشد",
                "confirm_password.required" => "تکرار رمز عبور الزامی است",
                "confirm_password.same" => "رمز عبور جدید با تکرار رمز عبور یکسان نیست",
            ]
        ];
    }
    protected static function profileBasic($data)
    {
        return [
            [
                'fullname' => 'required|min:4',
                'email' => 'required|email',
            ],
            [
                "fullname.required" => "نام و نام خانوادگی الزامی است",
                "fullname.min" => "نام و نام خانوادگی نمیتواند کمتر از 2 کاراکتر باشد",
                "email.email" => "ایمیل وارد شده صحیح نیست",
                "email.required" => "ایمیل الزامی است",
                "email.required" => "ایمیل الزامی است",
            ]
        ];
    }
    protected static function profileImage($data)
    {
        return [
            [
                "profile_image" => "required|file|max:2000|mimes:jpg,jpeg,png"
            ],
            [
                "profile_image.required" => "فایل الزامی است",
                "profile_image.file" => "تصویر پروفایل صحیح نیست",
                "profile_image.max" => "تصویر پروفایل باید کمتر از 2 مگابایت باشد",
                "profile_image.mimes" => "فرمت فایل باید PNG ، JPG یا JPEG باشد",
            ]
        ];
    }
    protected static function address($data)
    {
        return [
            [
                'postal_address' => 'required',
                'postal_code' => 'required',
                'province' => 'required|integer|exists:provinces,id',
                'city' => "required|integer",
                'recipient_fullname' => 'required|min:4',
                'recipient_email' => 'required|email',
                "recipient_phone" => ['required', 'regex:/(?:[0۰]|\+?[9۹][8۸])[9۹][\d۰-۹]{9}/'],
            ],
            [
                "postal_address.required" => "نشانی پستی الزامی است",
                "postal_code.required" => "کد پستی الزامی است",
                "province.required" => "استان الزامی است",
                "province.integer" => "استان انتخاب شده صحیح نیست",
                "province.exists" => "استان انتخاب شده صحیح نیست",
                "city.required" => "شهر الزامی است",
                "city.integer" => "شهر انتخاب شده صحیح نیست",
                "recipient_fullname.required" => "نام و نام خانوادگی گیرنده الزامی است",
                "recipient_fullname.min" => "نام و نام خانوادگی گیرنده نمیتواند کمتر از 2 کاراکتر باشد",
                "recipient_email.required" => "ایمیل گیرنده الزامی است",
                "recipient_email.email" => "ایمیل گیرنده وارد شده صحیح نیست",
                "recipient_phone.required" =>  "شماره تلفن گیرنده الزامی است",
                "recipient_phone.regex" => "شماره تلفن گیرنده وارد شده صحیح نیست",
            ]
        ];
    }
}
