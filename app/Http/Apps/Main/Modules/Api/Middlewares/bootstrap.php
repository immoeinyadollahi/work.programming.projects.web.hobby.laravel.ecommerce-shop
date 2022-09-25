<?php

use App\Http\Exceptions\Handler as ExceptionHandler;

// Config
_set_config("http.module", [
    "name" => "api",
    "exception_handler" => [ExceptionHandler::class, "api"],
]);
