<?php

namespace App\Database\Seeders;


use Illuminate\Support\Facades\Storage;

use App\Classes\Base\Database\Seeder;
use App\Database\Models\User;

class UndoFakeUser extends Seeder
{
    public function run()
    {
        $user = User::where("email", "moyaprga9731@gmail.com")->first();
        $profile_image = $user->profileImage()->first();
        $profile_image->is_default || Storage::delete($profile_image->path);
        $profile_image->_deleteFirst();
        $user->deleteEmailVerificationMail();
        $user->_deleteFirst();
    }
}
