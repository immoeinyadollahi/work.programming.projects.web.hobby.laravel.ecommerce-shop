<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class General extends Settings
{
    public string $website_name;
    public string $address;
    public string $phone;
    public array $logo;
    public array $social_media;
    public array $slideshow;

    public static function group(): string
    {
        return 'general';
    }
}
