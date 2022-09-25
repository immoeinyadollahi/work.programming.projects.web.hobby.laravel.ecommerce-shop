<?php

namespace App\Http\Apps\Main\Modules\Api\Controllers;

use App\Classes\Base\Routing\Controller;
use App\Database\Models\Coupon;

class CouponsController extends Controller
{
    public function postCoupon()
    {
        $req = request();
        $code = $req->input("code");
        if (!$code) _http_abort(422, "کد الزامی است");
        $coupon = Coupon::where(["code" => $code, "is_used" => false])->whereRaw("expires_at > CURRENT_TIMESTAMP")->first();
        if (!$coupon) _http_abort(422, "کد تخفیف معتبر نیست");
        session()->put("coupon_id", $coupon->id);
        return ["message" => "کد تخفیف اعمال شد"];
    }
    public function getRevokeCoupon()
    {
        session()->forget("coupon_id");
        return response()->_ok();
    }
}
