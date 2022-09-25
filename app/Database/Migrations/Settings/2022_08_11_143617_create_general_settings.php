<?php

use Illuminate\Support\Str;
use Spatie\LaravelSettings\Migrations\SettingsBlueprint;
use Spatie\LaravelSettings\Migrations\SettingsMigration;

class CreateGeneralSettings extends SettingsMigration
{
    public function up()
    {
        $this->migrator->inGroup("general", function (SettingsBlueprint $blueprint) {
            $blueprint->add("website_name", "فروشگاه اینترنتی");
            $blueprint->add("logo", ["url" => _get_config("resources.images.logo.placeholder.url"), "path" => ""]);
            $blueprint->add("social_media", ["facebook" => "", "twitter" => "", "telegram" => "", "whatsapp" => ""]);
            $blueprint->add("address", "");
            $blueprint->add("phone", "");
            $blueprint->add("slideshow", [
                "slides" => [
                    ["id" => Str::uuid(), "title" => "Lorem, ipsum dolor.", "description" => "Lorem ipsum dolor, sit amet consectetur adipisicing elit. Eaque itaque eveniet vitae dolores, optio nihil?", "link" => ["url" => "#", "title" => "متن تستی"], "images" => ["desktop" => ["url" => _get_config("resources.images.slideshow.placeholder.desktop.url"), "path" => ""], "mobile" => ["url" => _get_config("resources.images.slideshow.placeholder.mobile.url"), "path" => ""]]],
                    ["id" => Str::uuid(), "title" => "Lorem, ipsum dolor.", "description" => "Lorem ipsum dolor, sit amet consectetur adipisicing elit. Eaque itaque eveniet vitae dolores, optio nihil?", "link" => ["url" => "#", "title" => "متن تستی"], "images" => ["desktop" => ["url" => _get_config("resources.images.slideshow.placeholder.desktop.url"), "path" => ""], "mobile" => ["url" => _get_config("resources.images.slideshow.placeholder.mobile.url"), "path" => ""]]],
                    ["id" => Str::uuid(), "title" => "Lorem, ipsum dolor.", "description" => "Lorem ipsum dolor, sit amet consectetur adipisicing elit. Eaque itaque eveniet vitae dolores, optio nihil?", "link" => ["url" => "#", "title" => "متن تستی"], "images" => ["desktop" => ["url" => _get_config("resources.images.slideshow.placeholder.desktop.url"), "path" => ""], "mobile" => ["url" => _get_config("resources.images.slideshow.placeholder.mobile.url"), "path" => ""]]]
                ]
            ]);
        });
    }
}
