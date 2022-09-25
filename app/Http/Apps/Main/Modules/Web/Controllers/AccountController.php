<?php

namespace App\Http\Apps\Main\Modules\Web\Controllers;

use Exception;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Classes\Base\Routing\Controller;
use App\Database\Models\Cart;
use App\Database\Models\EmailVerificationToken;
use App\Database\Models\ResetPasswordToken;
use App\Database\Models\User;

use App\Http\Apps\Main\Validations\Account as AccountValidations;

class AccountController extends Controller
{
    public function postRegister()
    {
        $req = request();
        $req->_trimOnly(["email", "fullname"]);
        $validated = AccountValidations::register($req->input())->validate();
        if ($validated->failed) return back()->_withValidationResult($validated)->onlyInput("fullname", "email");
        $password = $req->input("password");
        $user = User::create(array_merge($req->only("email", "fullname"), ["password" => Hash::make($password)]));
        $user->profileImage()->create(["url" => _get_config("resources.images.users.placeholder.url"), "is_default" => true]);
        $user->assignRole("user");
        $user->sendEmailVerificationMail(fn ($token) => _route("verify-email", compact('token')));
        return redirect("/login")->_withMessage("ثبت نام موفقیت آمیز بود. تاییده ایمیل برایتان ارسال شد", "success");
    }
    public function postLogin()
    {
        $req = request();
        $req->_trimOnly(["email"]);
        $email = $req->input("email");
        $password = $req->input("password");
        $validated = AccountValidations::login($req->input())
            ->after(function ($errors, $messages) use ($email, $password, &$user) {
                if (!$errors->has("email")) { // we can also check if errors doesn't include password field
                    if ($user = User::where("email", $email)->first()) !$errors->has("password") && !($user->password && Hash::check($password, $user->password)) && $messages->add("کاربری با این مشخصات یافت نشد", "danger");
                    else $errors->add("email", "کاربری با این ایمیل یافت نشد");
                }
            })->validate();
        if ($validated->failed) return back()->_withValidationResult($validated)->onlyInput("email");
        // Cart Process
        $user_cart = $user->cart()->first();
        $request_cart = Cart::getRequestCart();
        if ($request_cart) {
            if ($user_cart) {
                $request_cart_items = $request_cart->items()->get();
                foreach ($request_cart_items as $request_cart_item) {
                    $item_product_su = $request_cart_item->productSu()->first();
                    $user_cart_item = $user_cart->items()->where("product_su_id", $item_product_su->id)->first();
                    if ($user_cart_item) {
                        $user_cart_item->quantity += $request_cart_item->quantity;
                        $user_cart_item->price = $request_cart_item->price;
                        $user_cart_item->save();
                        // we can here check if total quantity is greater that product su stock and clamp total quantity to product su stock, for simplicity we just set total quantity and show proper alert in cart page if same condition happend
                    } else {
                        $user_cart->items()->save($request_cart_item);
                    }
                    // here we can prevent adding product su quantity if product su stock is zero or if total quantity is greater that product su stock, otherwise we can show alert in cart page for simplicity
                }
                $request_cart->_deleteFirst();
            } else {
                $user->cart()->save($request_cart);
            }
            Cart::clearRequestCart();
        } else if (!$user_cart) {
            $user->cart()->create();
        }
        auth()->login($user, $req->boolean("remember"));
        session()->regenerate();
        return redirect()->intended()->_withMessage("خوش آمدید $user->fullname", "success");
    }
    public function postForgetPassword()
    {
        $req = request();
        $req->_trimOnly(["email"]);
        $email = $req->input("email");
        $validated = AccountValidations::forgetPassword($req->input())
            ->after(function ($errors) use ($email, &$user) {
                !$errors->has("email") && !($user = User::where("email", $email)->exists()) && $errors->add("email", "کاربری با این ایمیل یافت نشد");
            })->validate();
        if ($validated->failed) return back()->_withValidationResult($validated)->onlyInput("email");
        $user->sendResetPasswordMail($email, fn ($token) => _route('reset-password', compact('token')));
        return redirect("/")->_withMessage("ایمیل بازیابی برایتان ارسال شد", "success");
    }
    public function postResetPassword()
    {
        $req = request();
        $token = $req->input("token");
        $password = $req->input("password");
        $user = null;
        if ($token) {
            try {
                if ($token = ResetPasswordToken::verifyJwtToken($token)) {
                    $user = User::where("email", $token->email)->first();
                }
            } catch (Exception $ex) {
            }
        }
        if (!$user) return back()->_withMessage("مشکلی در فرایند بازیابی رمز عبور پیش آمده است", "warning");
        $validated = AccountValidations::resetPassword($req->input())->validate();
        if ($validated->failed) return back()->_withValidationResult($validated)->onlyInput("email");
        $user->deleteResetPasswordToken();
        $user->fill(["password" => Hash::make($password), "remember_token" => Str::random(60)]);
        $user->save();
        return redirect("/login")->_withMessage("رمز عبور شما تغییر تغییر کرد", "success");
    }
    public function getLogout()
    {
        auth()->logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect("/")->_withMessage("خروج موفقیت آمیز بود", "success");
    }
    public function getVerify()
    {
        $req = request();
        $token = $req->query("token");
        $user = null;
        if ($token) {
            try {
                if ($token = EmailVerificationToken::verifyJwtToken($token)) {
                    $user = User::where("email", $token->email)->first();
                }
            } catch (Exception $ex) {
            }
        }
        if (!$user) return back()->_withMessage("مشکلی در فرایند تایید ایمیل پیش آمده است", "warning");
        if ($user->hasVerifiedEmail()) return redirect("/")->_withMessage("ایمیل شما قبلا تایید شده است", "info");
        $user->markEmailAsVerified();
        $user->save();
        return redirect("/")->_withMessage("ایمیل شما تایید شد", "success");
    }
    public function getResendEmailVerificationMail()
    {
        $user = _user();
        if ($user->hasVerifiedEmail())  return back()->_withMessage("ایمیل شما قبلا تایید شده است", "info");
        $user->sendEmailVerificationMail();
        return back()->_withMessage("تاییده ایمیل برایتان ارسال شد", "success");
    }
}
