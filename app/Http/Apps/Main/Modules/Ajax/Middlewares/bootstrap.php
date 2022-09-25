<?php

use Illuminate\Support\Facades\View as View;

use App\Http\Exceptions\Handler as ExceptionHandler;

// Config
_set_config("http.module", [
    "name" => "ajax",
    "exception_handler" => [ExceptionHandler::class, "ajax"],
]);
// Views
View::addLocation(__DIR__ . "/../Views");
