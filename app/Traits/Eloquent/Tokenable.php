<?php

namespace App\Traits\Eloquent;

use Illuminate\Support\Str;

use App\Utilities\JWT;

trait Tokenable
{
    public static function createJwtToken($attributes, $token_expire = null)
    {
        $issue_id = Str::uuid()->toString();
        $token = JWT::sign(array_merge(["issue_id" => $issue_id], $token_expire ? ["exp" => time() + $token_expire] : []), env("JWT_TOKEN_SECRET"));
        return self::create(array_merge(["issue_id" => $issue_id, "token" => $token], $attributes));
    }
    public static function verifyJwtToken($token)
    {
        $payload = JWT::verify($token, env("JWT_TOKEN_SECRET"));
        if (($issue_id = $payload->issue_id ?? null) && ($existing_token = self::where(["issue_id" => $issue_id, "token" => $token])->first())) {
            return $existing_token;
        }
    }
}
