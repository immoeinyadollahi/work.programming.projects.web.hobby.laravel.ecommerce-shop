<?php

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;

// Session
session()->setName("ASSID");
// Config
_set_config("http.app", [
    "name" => "admin",
    "default-auth-roles" => ["admin"],
    "mix-manifest" => "admin"
]);
// Views
View::addNamespace("shared", __DIR__ . "/../Views");
// Paginator
Paginator::defaultView("shared::common.pagination");
