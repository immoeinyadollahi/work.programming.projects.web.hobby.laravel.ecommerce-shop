<?php

namespace App\Http\Apps\Main\Validations;

use App\Classes\Validation\Validation;

class Main extends Validation
{
    protected static function checkout($data)
    {
        $user = _user();
        return [
            [
                'address' => "required",
            ],
            [
                "address.required" => "آدرس تحویل سفارش الزامی است",
            ]
        ];
    }
    protected static function productComment($data)
    {
        return [
            [
                'text' => 'required',
                'rating' => 'required|integer|in:0,1,2,3,4,5',
            ],
            [
                "text.required" => "فیلد الزامی است",
                "rating.required" => "فیلد الزامی است",
                "rating.integer" => "فیلد صحیح نیست",
                "rating.in" => "فیلد صحیح نیست",
            ]
        ];
    }
    protected static function phone($data, $v)
    {
        return [
            [
                "phone" => ['required', 'regex:/(?:[0۰]|\+?[9۹][8۸])[9۹][\d۰-۹]{9}/'],
            ],
            [
                "phone.required" =>  "شماره موبایل الزامی است",
                "phone.regex" => "شماره موبایل وارد شده صحیح نیست",
            ]
        ];
    }
    protected static function otpVerification($data)
    {
        return [
            [
                "code" => 'required',
            ],
            [
                "code.required" =>  "کد تایید الزامی است",
            ]
        ];
    }
}
