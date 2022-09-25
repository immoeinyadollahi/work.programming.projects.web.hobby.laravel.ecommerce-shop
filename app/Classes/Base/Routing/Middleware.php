<?php

namespace App\Classes\Base\Routing;

class Middleware
{
    public static function middleware($name, ...$args)
    {
        $handler = [static::class, $name];
        return $args ? array_merge([$handler], $args) : $handler;
    }
}
