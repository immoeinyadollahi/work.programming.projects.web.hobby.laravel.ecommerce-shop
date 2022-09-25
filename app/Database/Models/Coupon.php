<?php

namespace App\Database\Models;

use App\Classes\Base\Database\Model;

class Coupon extends Model
{
    protected $table = 'coupons';

    public static function getRequestCoupon()
    {
        $coupon_id = session("coupon_id");
        if ($coupon_id) {
            $coupon = Coupon::where(["is_used" => false])->whereRaw("expires_at > CURRENT_TIMESTAMP")->first();
            if ($coupon) return $coupon;
            session()->forget("coupon_id");
        }
    }
}
