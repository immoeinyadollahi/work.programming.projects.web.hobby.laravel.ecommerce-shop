<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class HelpersServiceProvider extends ServiceProvider
{
    public function register()
    {
        require app_path("/Helpers/index.php");
    }
}
