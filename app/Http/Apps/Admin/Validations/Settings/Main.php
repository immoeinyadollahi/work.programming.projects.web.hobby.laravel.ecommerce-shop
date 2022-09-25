<?php

namespace App\Http\Apps\Admin\Validations\Settings;

use App\Classes\Validation\Validation;

class Main extends Validation
{
    protected static function logo($data)
    {
        return [
            [
                "logo" => "required|file|max:5000|mimes:jpg,jpeg,png"
            ],
            [
                "logo.required" => "فایل الزامی است",
                "logo.file" => "فایل صحیح نیست",
                "logo.max" => "فایل باید کمتر از 5 مگابایت باشد",
                "logo.mimes" => "فرمت فایل باید PNG ، JPG یا JPEG باشد",
            ]
        ];
    }
}
