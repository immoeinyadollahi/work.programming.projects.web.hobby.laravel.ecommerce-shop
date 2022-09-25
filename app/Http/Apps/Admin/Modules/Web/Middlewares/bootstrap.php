<?php

use Illuminate\Support\Facades\View as View;

use App\Http\Exceptions\Handler as ExceptionHandler;

// Config
_set_config("http.module", [
    "name" => "web",
    "exception_handler" => [ExceptionHandler::class, "web"]
]);
// Views
$composers = [
    "main" => function ($view) {
        // User
        $user = _user();
        if ($user) {
            $user->load("profileImage");
        }
        $view->_withData("user", $user);
    }
];
_register_pages_composers($composers);
_register_pages_creators([["views" => "pages.*", "composers" => "main", "exclude" => ["pages.errors.*", "pages.account.*"]]]);

View::addLocation(__DIR__ . "/../Views");
