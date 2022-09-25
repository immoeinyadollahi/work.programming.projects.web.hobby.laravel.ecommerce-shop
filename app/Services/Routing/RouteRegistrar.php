<?php

namespace App\Services\Routing;

use Closure;

use Laravel\SerializableClosure\SerializableClosure;
use Illuminate\Routing\RouteRegistrar as IlluminateRouteRegistrar;
use Illuminate\Support\Str;

use App\Http\Middlewares\Middleware;

class RouteRegistrar extends IlluminateRouteRegistrar
{
    private function mergeMiddlewares($middleware)
    {
        $this->attributes["data"]["middlewares"] ??= [];
        $middleware_id = Str::uuid()->toString();
        $this->attributes["data"]["middlewares"][$middleware_id] = $middleware;
        $this->middleware(array_merge($this->attributes["middleware"] ?? [], [Middleware::with(["middleware_id" => $middleware_id])]));
    }
    public function middlewares(...$middlewares)
    {
        foreach ($middlewares as $middleware) {
            $has_closure = false;
            if (is_callable($middleware)) {
                if ($middleware instanceof Closure) ($middleware = serialize(new SerializableClosure($middleware))) && ($has_closure = true);
                $middleware = ["handler" => $middleware, "has_closure" => $has_closure];
            } else {
                $middleware_args = array_slice($middleware, 1);
                if ($middleware_args) {
                    array_walk_recursive($middleware_args, function (&$value) use (&$has_closure) {
                        if ($value instanceof Closure) {
                            $value = serialize(new SerializableClosure($value));
                            $has_closure = true;
                        }
                    });
                }
                $middleware = ["handler" => $middleware[0], "args" => $middleware_args, "has_closure" => $has_closure];
            }
            $this->mergeMiddlewares($middleware);
        }
        return $this;
    }
    public function require(...$paths)
    {
        return $this->middlewares(function () use ($paths) {
            foreach ($paths as $path) require $path;
        });
    }
    public function bootstrap($path)
    {
        return $this->require($path);
    }
    public function groupWithFallback($callback)
    {
        $this->group(function () use ($callback) {
            $callback();
            _register_fallback_route();
        });
    }
}
