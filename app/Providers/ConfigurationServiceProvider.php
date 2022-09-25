<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ConfigurationServiceProvider extends ServiceProvider
{
    public function register()
    {
        config()->set(APP_CUSTOM_CONFIG_FIELD, require app_path("Config/index.php"));
    }
}
