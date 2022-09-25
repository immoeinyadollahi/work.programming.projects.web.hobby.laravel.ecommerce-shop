<?php

namespace App\Database\Seeders;

use Illuminate\Support\Facades\File;

use App\Classes\Base\Database\Seeder;
use App\Database\Models\Province;

class Locations extends Seeder
{
    public function run()
    {
        $provinces = json_decode(File::get(base_path("/data/locations/provinces.json")));
        $cities = json_decode(File::get(base_path("/data/locations/cities.json")));
        foreach ($provinces as $province) {
            $province = Province::create(["name" => $province->name, "slug" => $province->slug]);
            foreach (array_filter($cities, fn ($city) => $city->province_id === $province->id) as $city) {
                $province->cities()->create(["name" => $city->name, "slug" => $city->slug]);
            }
        }
    }
}
