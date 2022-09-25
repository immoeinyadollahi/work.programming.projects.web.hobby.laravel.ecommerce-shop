<?php

namespace App\Classes\Validation;

class Validation
{
    public static function __callStatic($name, $arguments)
    {
        $data = $arguments[0];
        $validator = new Validator($data);
        $base_validator = $validator->validator;
        _set_config("validator", $base_validator);
        [$rules, $messages] = call_user_func_array([static::class, $name], array_merge($arguments, [$base_validator]));
        $base_validator->setRules($rules);
        $base_validator->setCustomMessages($messages);
        return $validator;
    }
}
