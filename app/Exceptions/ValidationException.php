<?php

namespace App\Exceptions;

use Illuminate\Validation\ValidationException as IlluminateValidationException;
use Illuminate\Support\Arr;

class ValidationException extends IlluminateValidationException
{
    public $errors;
    public $messages;
    public $fields;
    public function __construct($validator, $sort = false)
    {
        parent::__construct($validator);
        $errors = collect($validator->errors()->toArray())->reduce(function ($acc, $current, $key) {
            $acc[$key] = $key === "extra" ? $current : $current[0];
            return $acc;
        }, []);
        if ($sort) {
            $rules = array_keys($validator->getRules());
            uksort($errors,  function ($a, $b) use ($rules) {
                $a_idx = array_search($rules, $a);
                $b_idx = array_search($rules, $b);
                if ($a_idx === -1) {
                    return 1;
                } else if ($b_idx === -1) {
                    return -1;
                }
                return $a_idx - $b_idx;
            });
        }
        $this->errors = $errors;
        $this->messages = collect($errors)->reduce(fn ($acc, $error) => array_merge($acc, Arr::wrap($error)), []);
        $this->fields = $validator->errors()->keys();
    }
}
