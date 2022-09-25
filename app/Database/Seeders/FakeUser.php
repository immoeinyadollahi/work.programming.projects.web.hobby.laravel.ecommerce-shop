<?php

namespace App\Database\Seeders;

use Illuminate\Support\Facades\Hash;

use App\Classes\Base\Database\Seeder;
use App\Database\Models\User;
use App\Database\Models\Province;
use App\Database\Models\City;
use App\Database\Factories\AddressFactory;

class FakeUser extends Seeder
{
    public function run()
    {
        $user = User::create(["email" => "moyaprga9731@gmail.com", "phone" => "09911218367", "fullname" => "Moein Yadollahi", "password" => Hash::make("1234")]);
        $user->profileImage()->create(["url" => _get_config("resources.images.users.placeholder.url"), "is_default" => true]);
        $user->assignRole("user", "admin");
        // $user->sendEmailVerificationMail();
        // Addresses
        AddressFactory::new()->count(5)->state([
            "user_id" => $user->id,
            "province_id" => Province::where("name", "مازندران")->first()->id,
            "city_id" => City::where("name", "نکا")->first()->id,
            "recipient_fullname" => "معین یداللهی",
            "recipient_email" => "moyaprga9731@gmail.com",
            "recipient_phone" => "09911218367"
        ])->create();
    }
}
