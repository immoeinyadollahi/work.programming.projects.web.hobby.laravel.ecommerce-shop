<?php

namespace App\Http\Apps\Admin\Validations\Settings;

use App\Classes\Validation\Validation;

class Slideshow extends Validation
{
    protected static function slide($data)
    {
        return [
            [
                "title" => "required",
                "desktop_image" => "required",
                "mobile_image" => "required",
            ],
            [
                "title.required" => "عنوان الزامی است",
                "desktop_image.required" => "تصویر دسکتاپ الزامی است",
                "mobile_image.required" => "تصویر موبایل الزامی است",
            ]
        ];
    }
    protected static function image($data)
    {
        return [
            [
                "image" => "required|file|max:5000|mimes:jpg,jpeg,png"
            ],
            [
                "image.required" => "فایل الزامی است",
                "image.file" => "فایل صحیح نیست",
                "image.max" => "فایل باید کمتر از 5 مگابایت باشد",
                "image.mimes" => "فرمت فایل باید PNG ، JPG یا JPEG باشد",
            ]
        ];
    }
}
