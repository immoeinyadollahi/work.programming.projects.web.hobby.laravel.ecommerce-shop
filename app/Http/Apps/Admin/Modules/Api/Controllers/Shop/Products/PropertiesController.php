<?php

namespace App\Http\Apps\Admin\Modules\Api\Controllers\Shop\Products;

use App\Classes\Base\Routing\Controller;
use App\Database\Models\Product;

class PropertiesController extends Controller
{
    public function getProperties($product_id)
    {
        $product = Product::findOrFail($product_id);
        return ["properties" => $product->properties()->_orderedByPivot()->with("pivot.value")->get()];
    }
    public function postSave($product_id)
    {
        $req = request();
        $product = Product::findOrFail($product_id);
        $product->properties()->sync(collect($req->input("properties"))->reduce(function ($acc, $current, $idx) {
            $acc[$current["property_id"]] = ["order" => $idx + 1, "property_value_id" => $current["value_id"]];
            return $acc;
        }, []));
        return response()->_ok();
    }
}
