<?php

namespace App\Providers\Packages;

use Illuminate\Support\ServiceProvider;

class LaravelSettingsServiceProvider extends ServiceProvider
{
    public function register()
    {
        config()->set("settings.migrations_paths", [database_path('Migrations/Settings')]);
    }
}
