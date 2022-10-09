<?php

namespace App\Http\Apps\Admin\Modules\Api\Controllers\Shop\Categories;

use App\Classes\Base\Routing\Controller;
use App\Database\Models\Category;
use App\Database\Models\CategoryPropertyX;

class PropertiesController extends Controller
{
    public function getProperties($category_id)
    {
        $category = Category::findOrFail($category_id);
        return ["properties" => $category->properties()->_orderedByPivot()->with(["pivot.values" => fn ($query) => $query->_orderedByPivot()])->get()];
    }
    public function postSaveProperties($category_id)
    {
        $req = request();
        if (!($category = Category::find($category_id))) _http_abort(404);
        $category->properties()->sync(collect($req->input("properties"))->reduce(function ($acc, $current, $idx) {
            $acc[$current] = ["order" => $idx + 1];
            return $acc;
        }, []));
        return ["properties" => $category->properties()->_orderedByPivot()->get()];
    }
    // property refers to pivot model not Property model
    public function postSavePropertyValues($property_id)
    {
        $req = request();
        if (!($property = CategoryPropertyX::find($property_id))) _http_abort(404);
        $property->values()->sync(collect($req->input("values"))->reduce(function ($acc, $current, $idx) {
            $acc[$current] = ["order" => $idx + 1];
            return $acc;
        }, []));
        return response()->_ok();
    }
}
