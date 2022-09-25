<?php

namespace App\Database\Seeders;

use App\Classes\Base\Database\Seeder;
use App\Database\Models\Brand;

class Brands extends Seeder
{
    public function run()
    {
        $brands = [
            [
                "en" => "samsung",
                "fa" => "سامسونگ",
                "slug" => "samsung",
            ],
            [
                "en" => "huawei",
                "fa" => "هوآوی",
                "slug" => "huawei",
            ],
            [
                "en" => "apple",
                "fa" => "اپل",
                "slug" => "apple",
            ],
            [
                "en" => "sony",
                "fa" => "سونی",
                "slug" => "sony",
            ],
            [
                "en" => "xiamoi",
                "fa" => "شیائومی",
                "slug" => "xiamoi",
            ]
        ];
        foreach ($brands as $brand) {
            $new_brand = Brand::create($brand);
            $new_brand->image()->create(["url" => _get_config("resources.images.brands.placeholder.url")]);
        }
    }
}
