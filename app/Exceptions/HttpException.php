<?php

namespace App\Exceptions;

use Illuminate\Support\Arr;
use Symfony\Component\HttpKernel\Exception\HttpException as SymfonyHttpException;

use App\Classes\Validation\ValidationResult;

class HttpException extends SymfonyHttpException
{
    public $context;
    public const CTX_RAW = 0;
    public const CTX_ERRORS = 1;
    public const CTX_MESSAGES = 2;

    public function __construct($status_code, $context = null, $context_type = null)
    {
        parent::__construct($status_code);
        if ($context) {
            if ($context instanceof ValidationResult) {
                $this->context = array_merge($context->exception ? ["errors" => $context->exception->errors] : [], $context->messagesBag->isNotEmpty() ? ["messages" => $context->messagesBag->all()] : []);
            } else {
                $context_type = $context_type ?: self::CTX_MESSAGES;
                switch ($context_type) {
                    case self::CTX_MESSAGES:
                        $this->context = ["messages" => Arr::wrap($context)];
                        break;
                    case self::CTX_ERRORS:
                        $this->context = ["errors" => $context];
                        break;
                    case self::CTX_RAW:
                        $this->context =  $context;
                        break;
                }
            }
        } else $this->context = null;
    }
}
