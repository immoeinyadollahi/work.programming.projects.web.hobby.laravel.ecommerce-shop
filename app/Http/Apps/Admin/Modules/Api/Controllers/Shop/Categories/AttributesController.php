<?php

namespace App\Http\Apps\Admin\Modules\Api\Controllers\Shop\Categories;

use App\Classes\Base\Routing\Controller;
use App\Database\Models\Category;
use App\Database\Models\CategoryAttributeX;

class AttributesController extends Controller
{
    public function postSaveAttributes($category_id)
    {
        $req = request();
        if (!($category = Category::find($category_id))) _http_abort(404);
        $category->attributes()->sync(collect($req->input("attributes"))->reduce(function ($acc, $current, $idx) {
            $acc[$current] = ["order" => $idx + 1];
            return $acc;
        }, []));
        return ["attributes" => $category->attributes()->_orderedByPivot()->get()];
    }
    // attribute refers to pivot model not Attribute model
    public function postSaveAttributeValues($attribute_id)
    {
        $req = request();
        if (!($attribute = CategoryAttributeX::find($attribute_id))) _http_abort(404);
        $attribute->values()->sync(collect($req->input("values"))->reduce(function ($acc, $current, $idx) {
            $acc[$current] = ["order" => $idx + 1];
            return $acc;
        }, []));
        return response()->_ok();
    }
}
