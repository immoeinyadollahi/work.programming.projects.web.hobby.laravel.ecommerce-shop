<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->routes(function () {
            require app_path("/Http/Apps/Main/routing.php");
            require app_path("/Http/Apps/Admin/routing.php");
            require app_path('/Http/Apps/Download/routing.php');
        });
    }
}
