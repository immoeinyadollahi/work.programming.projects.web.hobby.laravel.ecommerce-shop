<?php

namespace App\Database\Seeders;

use App\Classes\Base\Database\Seeder;
use App\Database\Models\Attribute;

class FakeAttributeValues extends Seeder
{
    public function run()
    {
        Attribute::where("en", "color")->first()->values()->createMany([
            ["en" => "red", "fa" => "قرمز", "meta" => ["code" => "#ff0000"]],
            ["en" => "blue", "fa" => "آبی", "meta" => ["code" => "#03e3fc"]],
            ["en" => "green", "fa" => "سبز", "meta" => ["code" => "#3dfc03"]],
            ["en" => "black", "fa" => "مشکی", "meta" => ["code" => "#000000"]],
        ]);;
        Attribute::where("en", "size")->first()->values()->createMany([
            ["en" => "S", "fa" => "کوچک"],
            ["en" => "M", "fa" => "متوسط"],
            ["en" => "L", "fa" => "بزرگ"],
            ["en" => "XL", "fa" => "بسیار بزرگ"],
        ]);;
    }
}
