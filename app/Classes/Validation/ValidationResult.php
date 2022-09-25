<?php

namespace App\Classes\Validation;

class ValidationResult
{
    public $messagesBag;
    public $exception;
    public $failed;

    public function __construct($failed, $exception = null, $messagesBag = null)
    {
        $this->failed = $failed;
        $this->exception = $exception;
        $this->messagesBag = $messagesBag;
    }
}
