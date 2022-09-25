<?php

namespace App\Http\Apps\Admin\Modules\Api\Controllers\Shop\Properties;

use App\Classes\Base\Routing\Controller;
use App\Database\Models\PropertyGroup;

class MainController extends Controller
{
    public function getGroupsWithProperties()
    {
        $groups = PropertyGroup::with(["properties" => fn ($query) => $query->latest(), "properties.values" => fn ($query) => $query->latest()])->latest()->get();
        return ["groups" => $groups];
    }
}
