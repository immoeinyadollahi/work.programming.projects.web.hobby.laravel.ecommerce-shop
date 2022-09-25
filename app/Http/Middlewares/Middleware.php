<?php

namespace App\Http\Middlewares;

use ReflectionParameter;

use Illuminate\Http\Request;
use TiMacDonald\Middleware\HasParameters;

class Middleware
{
    use HasParameters;
    public function handle(Request $req, $next, $middleware_id)
    {
        $middleware = $req->route()->getAction("data")["middlewares"][$middleware_id];

        $middleware_args = $middleware["args"] ?? [];
        if ($middleware["has_closure"]) {
            $this->unserializeClosure($middleware["handler"]);
            array_walk_recursive($middleware_args, fn (&$value) => $this->unserializeClosure($value));
        }
        $response = null;
        $handler_next_params = null;
        $next_callback = function () use (&$response, $next, $req) {
            return $response = $next($req);
        };
        try {
            $param = new ReflectionParameter($middleware["handler"], "next");
            if ($param->getPosition() === 0) $handler_next_params = $param;
        } catch (\Exception $ex) {
        }
        if ($result = call_user_func_array($middleware["handler"], $handler_next_params ? array_merge([$next_callback], $middleware_args) : $middleware_args)) {
            return $result;
        }
        return $response ?: $next($req);
    }
    private function unserializeClosure(&$value)
    {
        is_string($value) && strpos($value, "Laravel\SerializableClosure\SerializableClosure") !== false && ($value = unserialize($value)->getClosure());
    }
}
