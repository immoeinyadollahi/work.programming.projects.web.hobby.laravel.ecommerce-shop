<?php

namespace App\Http\Apps\Main\Modules\Web\Controllers\Users;

use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

use App\Classes\Base\Routing\Controller;
use App\Database\Models\User;

use App\Http\Apps\Main\Validations\Users as UsersValidations;

class MainController extends Controller
{
    public function getDashboard()
    {
        $user = _user();
        $user->load(["orders" => fn ($query) => $query->latest()->limit(5), "orders.items"]);
        return view("pages.users.dashboard");
    }
    public function postEditProfile()
    {
        $req = request();
        $req->_trimExcept(["profile_image"]);
        $email = $req->input("email");
        $profile_image_file = $req->file("profile_image");
        $user = _user();
        $validated = UsersValidations::editProfile($req->all())
            ->after(function ($errors) use ($user, $email) {
                !$errors->has("email") && $email !== $user->email && User::where("email", $email)->exists() && $errors->add("email", "کاربری با این ایمیل موجود است");
            })->validate();
        if ($validated->failed) return back()->_withValidationResult($validated)->onlyInput("fullname", "email", "phone");
        if ($profile_image_file) {
            // delete previous profile image
            $user_profile_image = $user->profileImage()->first();
            $user_profile_image->is_default || Storage::delete($user_profile_image->path);
            $user_profile_image->delete();

            $file_path = "/users/profile/" . $profile_image_file->hashName();
            Image::make($profile_image_file)->resize(100, 100)->save(Storage::path($file_path));
            $user->profileImage()->create(["path" => $file_path, "url" => Storage::url($file_path), "original_name" => $profile_image_file->getClientOriginalName()]);
        }
        $user->fill($req->only("email", "phone", "fullname"));
        $user->isDirty("email") && $user->unmarkVerifiedEmail();
        $user->save();
        return back()->_withMessage("تغییرات ثبت شد", "success");
    }
    public function postChangePassword()
    {
        $req = request();
        $new_password = $req->input("password");
        $user = _user();
        $validated = UsersValidations::changePassword($req->input())
            ->after(function ($errors) use ($new_password, $user) {
                $errors->isEmpty() && Hash::check($new_password, $user->password) && $errors->add("password", "رمز عبور جدید نباید تکراری باشد");
            })->validate();
        if ($validated->failed) return back()->_withValidationResult($validated);
        $user->password = Hash::make($new_password);
        $user->save();
        return back()->_withMessage("رمز عبور شما تغییر تغییر کرد", "success");
    }
}
