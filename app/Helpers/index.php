<?php

use Illuminate\Support\Facades\View as ViewFacade;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

use App\Exceptions\HttpException;
use App\Database\Models\User;

// Env
if (!function_exists("_is_dev")) {
    function _is_dev()
    {
        return env("APP_ENV") === "development";
    }
}
// Config
if (!function_exists("_get_config")) {
    function _get_config($key, $default = null)
    {
        return config(APP_CUSTOM_CONFIG_FIELD . "." . $key, $default);
    }
}
if (!function_exists("_set_config")) {
    function _set_config($key, $value)
    {
        config()->set(APP_CUSTOM_CONFIG_FIELD . "." . $key, $value);
    }
}
// Assets
if (!function_exists("_asset_url")) {
    function _asset_url($path)
    {
        return url("/public/" . ltrim($path, "/"));
    }
}
if (!function_exists("_asset_path")) {
    function _asset_path($path)
    {
        return public_path($path);
    }
}
// Mix
if (!function_exists("_mix")) {
    function _mix($path, $manifest = null)
    {
        return "/public" . mix($path, _get_config("mix.manifests." . ($manifest ?: _get_config("http.app.mix-manifest"))));
    }
}
// Http
if (!function_exists("_http_abort")) {
    function _http_abort($status_code, $context = null, $context_type = HttpException::CTX_MESSAGES)
    {
        throw new HttpException($status_code, $context, $context_type);
    }
}
// User
if (!function_exists("_user")) {
    /**
     * @return User
     */
    function _user($guard = null)
    {
        return auth($guard)->user();
    }
}
// Cookie
if (!function_exists("_remove_cookie")) {
    function _remove_cookie($name)
    {
        cookie()->queue(cookie()->forget($name));
    }
}
// Views
if (!function_exists("_register_pages_composers")) {
    function _register_pages_composers($composers)
    {
        ViewFacade::composer("pages.*", function ($view) use ($composers) {
            $view_composers = $view->getData()["composers"] ?? null;
            if ($view_composers) {
                foreach ($view_composers as $composer) {
                    $composers[$composer]($view);
                }
            }
        });
    }
}
if (!function_exists("_register_pages_creators")) {
    function _register_pages_creators($creators)
    {
        foreach ($creators as $creator) {
            ViewFacade::creator(Arr::wrap($creator["views"]), function ($view) use ($creator) {
                if (!isset($view->getData()["composers"]) && (!isset($creator["exclude"]) || !collect($creator["exclude"])->some(function ($value) use ($view) {

                    if (strpos($value, ".") === false) {
                        return $view->_fileName() === $value;
                    }
                    return Str::is($value, $view->name());
                }))) {
                    $view->with("composers", Arr::wrap($creator["composers"]));
                }
            });
        }
    }
}
if (!function_exists("_register_views_shared_data")) {
    function _register_views_shared_data($key, $value = null)
    {
        ViewFacade::share("_" . $key, $value);
    }
}
// Routing
if (!function_exists("_register_fallback_route")) {
    function _register_fallback_route()
    {
        require app_path("Http/Fallback/route.php");
    }
}
if (!function_exists("_route_name")) {
    function _route_name($name)
    {
        return _get_config("http.app.name") . "." . _get_config("http.module.name") . "." . $name;
    }
}
if (!function_exists("_is_route")) {
    function _is_route(...$names)
    {
        return request()->route()->named(...collect($names)->map(fn ($name) => _route_name($name)));
    }
}
if (!function_exists("_route")) {
    function _route($name, $params = [], $absolute = true)
    {
        return route(_route_name($name), $params, $absolute);
    }
}
// Misc
if (!function_exists("_data_set_callback")) {
    function _data_set_callback(&$target, $key, $callback, $overwrite = true)
    {
        $segments = is_array($key) ? $key : explode('.', $key);
        if (($segment = array_shift($segments)) === '*') {
            if (!Arr::accessible($target)) {
                $target = [];
            }
            if ($segments) {
                foreach ($target as &$inner) {
                    _data_set_callback($inner, $segments, $callback, $overwrite);
                }
            } else if ($overwrite) {
                foreach ($target as &$inner) {
                    $inner = $callback($inner);
                }
            }
        } else if (Arr::accessible($target)) {
            if ($segments) {
                if (!Arr::exists($target, $segment)) {
                    $target[$segment] = [];
                }

                _data_set_callback($target[$segment], $segments, $callback, $overwrite);
            } else if ($overwrite || !Arr::exists($target, $segment)) {
                $target[$segment] = $callback($target[$segment]);
            }
        } else if (is_object($target)) {
            if ($segments) {
                if (!isset($target->{$segment})) {
                    $target->{$segment} = [];
                }

                _data_set_callback($target->{$segment}, $segments, $callback, $overwrite);
            } else if ($overwrite || !isset($target->{$segment})) {
                $target->{$segment} = $callback($target->{$segment});
            }
        } else {
            $target = [];

            if ($segments) {
                _data_set_callback($target[$segment], $segments, $callback, $overwrite);
            } else if ($overwrite) {
                $target[$segment] = $callback($target[$segment]);
            }
        }
        return $target;
    }
}
if (!function_exists("_trim_deep")) {
    function _trim_deep($input, $keys, $transform = null)
    {
        foreach ($keys as $key) {
            _data_set_callback($input, $key, fn (&$value) => is_string($value) ? ($transform ? $transform(trim($value)) : trim($value))  : $value);
        }
        return $input;
    }
}
if (!function_exists("_trim_array")) {
    function _trim_array($input, $transform = null)
    {
        foreach ($input as $key => $value) {
            if (is_string($value)) {
                $input[$key] = $transform ? $transform(trim($value)) : trim($value);
            }
        }
        return $input;
    }
}
