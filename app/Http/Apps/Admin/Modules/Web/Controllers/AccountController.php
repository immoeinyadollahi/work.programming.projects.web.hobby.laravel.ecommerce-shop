<?php

namespace App\Http\Apps\Admin\Modules\Web\Controllers;

use Illuminate\Support\Facades\Hash;

use App\Classes\Base\Routing\Controller;
use App\Database\Models\User;

use App\Http\Apps\Admin\Validations\Account as AccountValidations;

class AccountController extends Controller
{
    public function postLogin()
    {
        $req = request();
        $req->_trimOnly(["email"]);
        $email = $req->input("email");
        $password = $req->input("password");
        $validated = AccountValidations::login($req->input())
            ->after(function ($errors, $messages) use ($email, $password, &$user) {
                if ($errors->any()) return;
                if ($user = User::where("email", $email)->first()) {
                    if ($user->hasRole("admin")) {
                        if (!$user->password || !Hash::check($password, $user->password)) {
                            $messages->add("کاربری با این مشخصات یافت نشد", "danger");
                        }
                    } else {
                        $messages->add("دسترسی مجاز نیست", "danger");
                    }
                } else $errors->add("email", "کاربری با این ایمیل یافت نشد");
            })->validate();
        if ($validated->failed) return back()->_withValidationResult($validated)->onlyInput("email");

        auth()->login($user, true);
        session()->regenerate();
        return redirect()->intended("/")->_withMessage("خوش آمدید $user->fullname", "success");
    }
}
