<?php

namespace App\Database\Seeders;

use App\Classes\Base\Database\Seeder;
use App\Database\Models\Attribute;

class Attributes extends Seeder
{
    public function run()
    {
        $attributes = [
            [
                "en" => "color",
                "fa" => "رنگ",
            ],
            [
                "en" => "size",
                "fa" => "سایز"
            ]
        ];
        foreach ($attributes as $attribute) {
            Attribute::create($attribute);
        }
    }
}
