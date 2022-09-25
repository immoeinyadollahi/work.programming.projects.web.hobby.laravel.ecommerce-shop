<?php

namespace App\Http\Apps\Main\Modules\Api\Controllers;

use App\Classes\Base\Routing\Controller;
use App\Database\Models\Province;

class AddressesController extends Controller
{
    public function getProvinceCities($province_id)
    {
        if (!($province = Province::find($province_id)));
        return $province->cities()->get();
    }
}
