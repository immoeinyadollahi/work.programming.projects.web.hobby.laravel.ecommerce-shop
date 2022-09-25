<?php

namespace App\Http\Apps\Admin\Modules\Api\Controllers\Shop\Products;

use Illuminate\Database\Eloquent\Collection;

use App\Classes\Base\Routing\Controller;
use App\Database\Models\Product;

class PropertiesController extends Controller
{
    public function getCategoryProperties($product_id)
    {
        if (!($product = Product::find($product_id))) _http_abort(404);
        $category = $product->categories()->orderBy("level", "desc")->first();
        $category_properties = $category->properties()->_orderedByPivot()->get();
        (new Collection($category_properties->pluck("pivot")))->load(["values" => fn ($query) => $query->_orderedByPivot()]);
        return ["properties" => $category_properties];
    }
    public function getProperties($product_id)
    {
        if (!($product = Product::find($product_id))) _http_abort(404);
        $properties = $product->properties()->with("property")->_orderedByPivot()->get();
        return ["properties" => $properties];
    }
    public function postSave($product_id)
    {
        $req = request();
        if (!($product = Product::find($product_id))) _http_abort(404);
        $product->properties()->sync(collect($req->input("properties"))->reduce(function ($acc, $current, $idx) {
            $acc[$current["value_id"]] = ["order" => $idx + 1, "property_id" => $current["property_id"]];
            return $acc;
        }, []));
        return response()->_ok();
    }
}
