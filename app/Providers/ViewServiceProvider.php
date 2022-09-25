<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

use App\Utilities\Date;
use App\Utilities\Arr;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        _register_views_shared_data("Arr", Arr::class);
        _register_views_shared_data("Date", Date::class);
        _register_views_shared_data("req", request());

        View::addNamespace("mail", app_path("/Mail/Templates"));
    }
}
