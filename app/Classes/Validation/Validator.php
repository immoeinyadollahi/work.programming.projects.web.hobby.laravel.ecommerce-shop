<?php

namespace App\Classes\Validation;

use App\Exceptions\ValidationException;

class Validator
{
    public $validator;
    public $messagesBag;
    public $hasAfterCallback = false;

    public function __construct($data, $rules = [], $messages = [])
    {
        $this->validator = validator($data, $rules, $messages);
        $this->messagesBag = new MessagesBag();
    }
    public function after($callback)
    {
        $this->hasAfterCallback || ($this->hasAfterCallback = true);
        $this->validator->after(fn ($validator) => $callback($validator->errors(), $this->messagesBag));
        return $this;
    }
    public function validate()
    {
        if ($this->validator->fails()) {
            return new ValidationResult(true, new ValidationException($this->validator, $this->hasAfterCallback), $this->messagesBag);
        }
        if ($this->messagesBag->isNotEmpty()) {
            return new ValidationResult(true, null, $this->messagesBag);
        }
        return new ValidationResult(false);
    }
}
