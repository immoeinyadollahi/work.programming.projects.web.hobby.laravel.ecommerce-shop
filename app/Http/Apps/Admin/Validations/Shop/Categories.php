<?php

namespace App\Http\Apps\Admin\Validations\Shop;

use App\Classes\Validation\Validation;

class Categories extends Validation
{
    protected static function category($data)
    {
        return [
            [
                'en' => 'required',
                'fa' => 'required',
            ], [
                "en.required" => "نام انگلیسی الزامی می باشد",
                "fa.required" => "نام فارسی الزامی می باشد",
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
                "image.required" => "تصویر دسته بندی الزامی است",
                "image.file" => "تصویر دسته بندی صحیح نیست",
                "image.max" => "تصویر دسته بندی باید کمتر از 5 مگابایت باشد",
                "image.mimes" => "فرمت فایل باید PNG ، JPG یا JPEG باشد",
            ]
        ];
    }
}
