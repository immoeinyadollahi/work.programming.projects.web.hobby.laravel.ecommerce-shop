<?php

namespace App\Http\Apps\Main\Modules\Web\Controllers\Users;

use App\Classes\Base\Routing\Controller;
use App\Database\Models\Address;
use App\Database\Models\City;
use App\Database\Models\Province;

use App\Http\Apps\Main\Validations\Users as UsersValidations;

class AddressesController extends Controller
{
    public function getAddresses()
    {
        $user = _user();
        $user->load(["addresses" => fn ($query) => $query->latest(), "addresses.province", "addresses.city"]);
        return view("pages.users.addresses");
    }
    public function getAddAddress()
    {
        $provinces = Province::all();
        return view("pages.users.add-address", ["provinces" => $provinces]);
    }
    public function postAddAddress()
    {
        $user = _user();
        $req = request();
        $validated = UsersValidations::address($req->input())->after(function ($errors) use ($req) {
            if ($errors->hasAny("province", "city")) return;
            if (!City::where(["id" => $req->input("city"), "province_id" => $req->input("province")])->first()) $errors->add("city", "شهر انتخاب شده صحیح نیست");
        })->validate();
        if ($validated->failed) return back()->_withValidationResult($validated)->withInput();
        $user->addresses()->create(array_merge($req->only("recipient_fullname", "recipient_email", "recipient_phone", "postal_address", "postal_code"), ["province_id" => $req->input("province"), "city_id" => $req->input("city")]));
        return redirect()->_route("users.addresses")->_withMessage("آدرس جدید ثبت شد", "success");
    }
    public function getEditAddress($address_id)
    {
        if (!($address = Address::find($address_id))) _http_abort(404);
        $provinces = Province::all();
        $cities = City::where("province_id", $address->province_id)->get();
        return view("pages.users.edit-address", ['address' => $address, "provinces" => $provinces, "cities" => $cities]);
    }
    public function postEditAddress($address_id)
    {
        $req = request();
        if (!($address = Address::find($address_id))) _http_abort(404);
        $validated = UsersValidations::address($req->input())->after(function ($errors) use ($req) {
            if ($errors->hasAny("province", "city")) return;
            if (!City::where(["id" => $req->input("city"), "province_id" => $req->input("province")])->first()) $errors->add("city", "شهر انتخاب شده صحیح نیست");
        })->validate();
        if ($validated->failed) return back()->_withValidationResult($validated)->withInput();
        $address->fill(array_merge($req->only("recipient_fullname", "recipient_email", "recipient_phone", "postal_address", "postal_code"), ["province_id" => $req->input("province"), "city_id" => $req->input("city")]));
        return redirect()->_route("users.addresses")->_withMessage("تغییرات ثبت شد", "success");
    }
    public function getRemoveAddress($address_id)
    {
        if (!Address::where("id", $address_id)->_deleteFirst()) _http_abort(404);
        return back()->_withMessage("آدرس مورد نظر حذف شد", "success");
    }
}
