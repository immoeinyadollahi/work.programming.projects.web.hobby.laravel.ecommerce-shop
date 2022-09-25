<?php

namespace App\Utilities;

class Path
{
    public static function join(...$paths)
    {
        return rtrim(preg_replace('~\/+~', "/", implode("/", $paths)), "/");
    }
    public static function resolve(...$paths)
    {
        return self::join(base_path(), ...$paths);
    }
    public static function extname($path)
    {
        return pathinfo($path, PATHINFO_EXTENSION);
    }
}
