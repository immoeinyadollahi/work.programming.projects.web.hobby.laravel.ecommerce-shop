<?php

namespace App\Http\Exceptions;

use App\Exceptions\HttpException;

class Handler
{
    public static function api(HttpException $ex)
    {
        $status = $ex->getStatusCode();
        $context = $ex->context;
        if ($status !== 500 && $context) return response()->json($context, $status);
        return response(null, $status);
    }
    public static function ajax(HttpException $ex)
    {
        return self::api($ex);
    }
    public static function web(HttpException $ex)
    {
        $status = $ex->getStatusCode();
        return response()->view("pages.errors.$status")->setStatusCode($status);
    }
}
