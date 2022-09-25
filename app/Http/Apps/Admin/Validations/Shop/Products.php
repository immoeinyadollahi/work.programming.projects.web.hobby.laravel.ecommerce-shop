<?php

namespace App\Http\Apps\Admin\Validations\Shop;

use App\Classes\Validation\Validation;
use App\Classes\Validation\Rules;

class Products extends Validation
{
    protected static function product($data)
    {
        return [
            [
                'name' => 'required',
            ], [
                "name.required" => "نام الزامی می باشد",
            ]
        ];
    }
    protected static function simpleTypeSu($data)
    {
        return [
            [
                'price' => 'nullable|numeric|min:0',
                'discounted_price' => ['nullable', 'numeric', "min:0", Rules::dependsTo("price", "قیمت هم الزامی می باشد"), "lt:price"],
                'discount_expire' => ['nullable', 'date', Rules::dependsTo("discounted_price", "قیمت تخفیف هم الزامی می باشد")],
                'stock' => 'nullable|numeric|min:0',
            ],
            [
                "price.numeric" => "لطفا قیمت صحیح وارد کنید",
                "price.min" => "لطفا قیمت صحیح وارد کنید",
                "discounted_price.numeric" => "لطفا قیمت تخفیف صحیح وارد کنید",
                "discounted_price.min" => "لطفا قیمت تخفیف صحیح وارد کنید",
                "discounted_price.lt" => "قیمت تخفیف باید کمتر از قیمت اصلی باشد",
                "discount_expire.date" => "لطفا تاریخ انقضا صحیح وارد کنید",
                "stock.numeric" => "لطفا موجودی صحیح وارد کنید",
                "stock.min" => "لطفا موجودی صحیح وارد کنید",
            ]
        ];
    }
    protected static function variableTypeVariation($data)
    {
        return [
            [
                'price' => 'nullable|numeric|min:0',
                'discounted_price' => ['nullable', 'numeric', "min:0", Rules::dependsTo("price", "قیمت هم الزامی می باشد"), "lt:price"],
                'discount_expire' => ['nullable', 'date', Rules::dependsTo("discounted_price", "قیمت تخفیف هم الزامی می باشد")],
                'stock' => 'nullable|numeric|min:0',
            ],
            [
                "price.numeric" => "لطفا قیمت صحیح وارد کنید",
                "price.min" => "لطفا قیمت صحیح وارد کنید",
                "discounted_price.numeric" => "لطفا قیمت تخفیف صحیح وارد کنید",
                "discounted_price.min" => "لطفا قیمت تخفیف صحیح وارد کنید",
                "discounted_price.lt" => "قیمت تخفیف باید کمتر از قیمت اصلی باشد",
                "discount_expire.date" => "لطفا تاریخ انقضا صحیح وارد کنید",
                "stock.numeric" => "لطفا موجودی صحیح وارد کنید",
                "stock.min" => "لطفا موجودی صحیح وارد کنید",
            ]
        ];
    }
    protected static function specificationGroup($data)
    {
        return [
            [
                'name' => 'required',
            ],
            [
                "name.required" => "نام گروه الزامی می باشد",
            ]
        ];
    }
    protected static function specificationGroupItem($data)
    {
        return [
            [
                'name' => 'required',
                "type" => "required|in:text,boolean",
                'value' => 'required',
            ],
            [
                "name.required" => "نام الزامی می باشد",
                "type.required" => "لطفا اطلاعات صحیح وارد کنید",
                "type.in" => "لطفا اطلاعات صحیح وارد کنید",
                "value.required" => "مقدار الزامی می باشد",
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
                "image.required" => "تصویر پروفایل الزامی است",
                "image.file" => "تصویر پروفایل صحیح نیست",
                "image.max" => "تصویر پروفایل باید کمتر از 5 مگابایت باشد",
                "image.mimes" => "فرمت فایل باید PNG ، JPG یا JPEG باشد",
            ]
        ];
    }
    protected static function thumbnail($data)
    {
        return [
            [
                "thumbnail" => "required|file|max:5000|mimes:jpg,jpeg,png"
            ],
            [
                "thumbnail.required" => "تصویر گالری الزامی است",
                "thumbnail.file" => "تصویر گالری صحیح نیست",
                "thumbnail.max" => "تصویر گالری باید کمتر از 5 مگابایت باشد",
                "thumbnail.mimes" => "فرمت فایل باید PNG ، JPG یا JPEG باشد",
            ]
        ];
    }
}
