<?php

namespace App\Http\Apps\Main\Modules\Web\Controllers\Users;

use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

use App\Classes\Base\Routing\Controller;
use App\Database\Models\User;

use App\Http\Apps\Main\Validations\Users as UsersValidations;

class ProfileController extends Controller
{
    public function postProfileBasic()
    {
        $req = request();
        $req->_trimAll();
        $email = $req->input("email");
        $user = _user();
        $validated = UsersValidations::profileBasic($req->all())
            ->after(function ($errors) use ($user, $email) {
                !$errors->has("email") && $email !== $user->email && User::where("email", $email)->exists() && $errors->add("email", "کاربری با این ایمیل موجود است");
            })->validate();
        if ($validated->failed) return back()->_withValidationResult($validated)->withInput();
        $user->fill($req->only("email", "phone", "fullname"));
        $user->isDirty("email") && $user->unmarkVerifiedEmail();
        $user->save();
        return back()->_withMessage("تغییرات ثبت شد", "success");
    }
    public function postProfileImage()
    {
        $req = request();
        $profile_image_file = $req->file("profile_image");
        $user = _user();
        $validated = UsersValidations::profileImage($req->all())->validate();
        if ($validated->failed) return back()->_withMessages($validated->exception->messages, "danger");
        // delete previous profile image
        $user_profile_image = $user->profileImage()->first();
        $user_profile_image->is_default || Storage::delete($user_profile_image->path);
        $user_profile_image->delete();

        $file_path = "/users/profile/" . $profile_image_file->hashName();
        Image::make($profile_image_file)->resize(100, 100)->save(Storage::path($file_path));
        $user->profileImage()->create(["path" => $file_path, "url" => Storage::url($file_path), "original_name" => $profile_image_file->getClientOriginalName()]);
        return back()->_withMessage("تغییرات ثبت شد", "success");
    }
}
