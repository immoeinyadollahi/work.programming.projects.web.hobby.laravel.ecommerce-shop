<?php

namespace App\Utilities;

use RecursiveArrayIterator;
use RecursiveIteratorIterator;

class Arr
{
    public static function walkRecursive($arr, $callback, $max_depth = INF, $depth = 0)
    {
        if ($depth < $max_depth - 1) {
            foreach ($arr as $key => $value) {
                if (is_array($value) && !is_callable($value)) {
                    self::walkRecursive($value, $callback, $max_depth, $depth + 1);
                } else {
                    $callback($value, $key);
                }
            }
        } else {
            $callback($arr);
        }
    }
    public static function getDepth($arr)
    {
        $depth = 0;
        $iteIte = new RecursiveIteratorIterator(new RecursiveArrayIterator($arr));
        foreach ($iteIte as $ite) {
            $d = $iteIte->getDepth();
            $depth = $d > $depth ? $d : $depth;
        }

        return $depth;
    }
}
