<?php

namespace App\Http\Apps\Admin\Modules\Api\Controllers\Shop\Products\VariableType;

use App\Classes\Base\Routing\Controller;
use App\Database\Models\Product;

class AttributesController extends Controller
{
    public function postAttribute($product_id)
    {
        $product = Product::findOrFail($product_id);
        $attribute_id = request("attribute_id");
        $order = $product->variableTypeAttributes()->count() + 1;
        $product->variableTypeAttributes()->attach($attribute_id, ["order" => $order]);
        $product->variableTypeVariations()->get()->each(fn ($variation) => $variation->variableProductTypeAttributes()->attach($attribute_id, ["order" => $order]));
        return ["attribute" => $product->variableTypeAttributes()->wherePivot("attribute_id", $attribute_id)->first()];
    }
    public function postSaveOrdering($product_id)
    {
        $product = Product::findOrFail($product_id);
        $attribute_ids = collect(request("attributes"));
        $product->sortVariableTypeAttributes($attribute_ids);
        return response()->_ok();
    }
    public function deleteAttribute($product_id, $attribute_id)
    {
        $product = Product::findOrFail($product_id);
        $product->variableTypeAttributes()->detach($attribute_id);
        $product->variableTypeVariations()->get()->each(fn ($variation) => $variation->variableProductTypeAttributes()->detach($attribute_id));
        $product->rearrangeVariableTypeAttributes();
        return response()->_ok();
    }
    public function patchValues($product_id, $attribute_id)
    {
        $product = Product::findOrFail($product_id);
        $values = request("values");
        $product_attribute = $product->variableTypeAttributes()->wherePivot("attribute_id", $attribute_id)->first();
        $product_attribute->pivot->values()->sync($values);
        $product->variableTypeVariations()->get()->each(function ($variation) use ($values, $attribute_id) {
            $attribute =  $variation->variableProductTypeAttributes()->where("attribute_id", $attribute_id)->first();
            $attribute_value_id = $attribute->pivot->attribute_value_id;
            if ($attribute_value_id && !in_array($attribute_value_id, $values)) {
                $attribute->pivot->update(['attribute_value_id' => null]);
            }
        });
        return ["values" => $product_attribute->pivot->values()->get()];
    }
}
