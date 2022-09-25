<?php

namespace App\Utilities;

use Firebase\JWT\JWT as FirebaseJWT;
use Firebase\JWT\Key as FirebaseJWTKey;

class JWT
{
    public static function sign($payload, $key, $algorithm = "HS256")
    {
        $payload["iat"] = time();
        return FirebaseJWT::encode($payload, $key, $algorithm);
    }
    public static function verify($jwt, $key, $algorithm = "HS256")
    {
        return FirebaseJWT::decode($jwt, new FirebaseJWTKey($key, $algorithm));
    }
}
