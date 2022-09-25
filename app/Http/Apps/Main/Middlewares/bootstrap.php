<?php

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;

// Session
session()->setName("PSSID");
// Config
_set_config("http.app", [
    "name" => "main",
    "default-auth-roles" => ["user"],
    "mix-manifest" => "main"
]);
// Views
View::addNamespace("shared", __DIR__ . "/../Views");
// Paginator
Paginator::defaultView("shared::common.pagination");
