<?php

namespace App\Classes\Validation;

use Illuminate\Support\Arr;

class Rules
{
    public static function dependsTo($target, $message)
    {
        return function ($attribute, $value, $fail) use ($target, $message) {
            $validator = self::getValidator();
            if ($validator->validateRequired($attribute, $value) && !$validator->validateRequired($target, self::getAttributeValue($target))) {
                $fail($message);
            }
        };
    }

    private static function getValidator()
    {
        return _get_config("validator");
    }
    private static function getAttributeValue($attribute)
    {
        return Arr::get(self::getValidator()->getData(), $attribute);
    }
}
