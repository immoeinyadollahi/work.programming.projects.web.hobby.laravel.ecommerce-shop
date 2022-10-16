<?php

namespace App\Http\Apps\Admin\Modules\Api\Controllers\Shop\Specifications;

use App\Classes\Base\Routing\Controller;
use App\Database\Models\SpecificationGroup;

class MainController extends Controller
{
    public function getSearchGroups()
    {
        $req = request();
        $search_term = $req->query("q");
        return ['groups' => SpecificationGroup::where("name", "LIKE", '%' . $search_term . '%')->get()];
    }
    public function getGroupSpecifications($group_id)
    {
        $group = SpecificationGroup::findOrFail($group_id);
        return ['specifications' => $group->specifications()->_ordered()->with(['items' => fn ($query) => $query->_ordered()])->get()];
    }
}
