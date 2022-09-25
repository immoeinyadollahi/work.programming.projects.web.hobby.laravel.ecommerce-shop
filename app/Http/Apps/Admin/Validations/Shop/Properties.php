<?php

namespace App\Http\Apps\Admin\Validations\Shop;

use App\Classes\Validation\Validation;

class Properties extends Validation
{
    protected static function group($data)
    {
        return [
            [
                'name' => 'required',
            ], [
                "name.required" => "نام الزامی می باشد",
            ]
        ];
    }
    protected static function property($data)
    {
        return [
            [
                "name" => "required"
            ],
            [
                "name.required" => "نام الزامی می باشد",
            ]
        ];
    }
}
