<?php

namespace App\Services\Routing;

use Illuminate\Routing\Router as IlluminateRouter;

class Router extends IlluminateRouter
{
    public function newRoute($methods, $uri, $action)
    {
        return (new Route($methods, $uri, $action))->setRouter($this)->setContainer($this->container);
    }
    public function __call($method, $parameters)
    {
        if (static::hasMacro($method)) return $this->macroCall($method, $parameters);
        $registrar = new RouteRegistrar($this);
        if ($method === "middlewares") return $registrar->middlewares(...$parameters);
        return $registrar->attribute($method, $method === 'middleware' ? (is_array($parameters[0]) ? $parameters[0] : $parameters) : (array_key_exists(0, $parameters) ? $parameters[0] : true));
    }
}
