<?php

namespace App\Http\Apps\Admin\Modules\Api\Controllers\Shop\Products\VariableType;

use App\Classes\Base\Routing\Controller;
use App\Database\Models\Product;
use App\Database\Models\VariableProductAttribute;

class AttributesController extends Controller
{
    public function postAttribute($product_id)
    {
        $req = request();
        if (!($product = Product::find($product_id))) _http_abort(404);
        $attribute_id = $req->input("attribute_id");
        $order = $product->variableTypeAttributes()->count() + 1;
        $product->variableTypeAttributes()->attach($attribute_id, ["order" => $order]);
        $variations = $product->variableTypeVariations()->get();
        foreach ($variations as $variation) {
            $variation->variableProductTypeAttributePivots()->create(["order" => $order, "attribute_id" => $attribute_id]);
        }
        return ["attribute" => VariableProductAttribute::where(["product_id" => $product_id, "attribute_id" => $attribute_id])->first()];
    }
    public function postSaveOrdering($product_id)
    {
        $product_attributes = request("attributes");
        $product = Product::find($product_id);
        $variations = $product->variableTypeVariations()->get();
        foreach ($product_attributes as $key => $product_attribute_id) {
            $order = $key + 1;
            $product_attribute = VariableProductAttribute::find($product_attribute_id);
            $product_attribute->order = $order;
            $product_attribute->save();
            foreach ($variations as $variation) {
                $variation->variableProductTypeAttributePivots()->where("attribute_id", $product_attribute->attribute_id)->_updateFirst(["order" => $order]);
            }
        }
        return response()->_ok();
    }
    public function deleteAttribute($attribute_id)
    {
        if (!($product_attribute = VariableProductAttribute::find($attribute_id))) _http_abort(404);
        $product = $product_attribute->product()->first();
        $variations = $product->variableTypeVariations()->get();
        $product_attribute->delete();
        foreach ($variations as $variation) {
            $variation->variableProductTypeAttributePivots()->where("attribute_id", $product_attribute->attribute_id)->_deleteFirst();
        }

        $product_attributes = $product->variableTypeAttributes()->_orderedByPivot()->get();
        foreach ($product_attributes as $key => $attribute) {
            $order = $key + 1;
            $attribute->pivot->order = $order;
            $attribute->pivot->save();
            foreach ($variations as $variation) {
                $variation->variableProductTypeAttributePivots()->where("attribute_id", $attribute->id)->_updateFirst(["order" => $order]);
            }
        }
        return response()->_ok();
    }
    public function patchValues($attribute_id)
    {
        if (!($product_attribute = VariableProductAttribute::find($attribute_id))) _http_abort(404);
        $values = request("values");
        $product = $product_attribute->product()->first();
        $product_attribute->values()->sync($values);
        $variations = $product->variableTypeVariations()->get();
        foreach ($variations as $variation) {
            $variation->variableProductTypeAttributePivots()->where("attribute_id", $product_attribute->attribute_id)->whereNotNull("attribute_value_id")->whereNotIn("attribute_value_id", $values)->_updateFirst(["attribute_value_id" => null]);
        }
        return response()->_ok();
    }
}
