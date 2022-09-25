<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class PathsServiceProvider extends ServiceProvider
{
    public function register()
    {
        if (!_is_dev()) {
            $this->app->instance("path.public", base_path("../public_html/public"));
        }
        $this->app->useDatabasePath(app_path("Database"));
    }
}
