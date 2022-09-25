<?php

namespace App\Http\Middlewares;

use App\Classes\Base\Routing\Middleware;

class Auth extends Middleware
{
    public static function web($options = [])
    {
        extract(array_merge(["guest" => false, "roles" => _get_config("http.app.default-auth-roles")], $options));
        $user = _user();
        if ($guest) {
            if ($user) return redirect("/");
        } else if ($user) {
            if (!$user->hasAnyRole($roles)) _http_abort(403);
        } else return redirect()->guest("/login");
    }
    public static function api($options = [])
    {
        extract(array_merge(["guest" => false, "roles" => _get_config("http.app.default-auth-roles")], $options));
        $user = _user();
        if ($guest) {
            if ($user) _http_abort(403);
        } else if ($user) {
            if (!$user->hasAnyRole($roles)) _http_abort(403);
        } else _http_abort(401);
    }
    public static function ajax($options = [])
    {
        return self::api($options);
    }
}
