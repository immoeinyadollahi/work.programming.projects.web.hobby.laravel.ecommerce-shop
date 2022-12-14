<?php

namespace App\Http\Apps\Admin\Modules\Api\Controllers\Shop\Products\VariableType;

use BenTools\CartesianProduct\CartesianProduct;

use App\Classes\Base\Routing\Controller;
use App\Database\Models\ProductSu;
use App\Database\Models\Product;
use App\Exceptions\HttpException;

use App\Http\Apps\Admin\Validations\Shop\Products as ProductsValidations;

class VariationsController extends Controller
{
    public function getVariations($product_id)
    {
        $product = Product::findOrFail($product_id);
        return ["variations" => $product->variableTypeVariations()->with(["variableProductTypeAttributes" => fn ($query) => $query->_orderedByPivot()])->_ordered()->get()];
    }
    public function getPerformAction($product_id, $action_name)
    {
        $product = Product::findOrFail($product_id);
        switch ($action_name) {
            case "create-variation":
                $variation_order = $product->variableTypeVariations()->count() + 1;
                $variation = $product->su()->create(["product_type" => "variable", "order" => $variation_order]);
                $variation_attributes = $product->variableTypeAttributes()->_orderedByPivot()->pluck("attributes.id")->reduce(function ($acc, $current, $key) {
                    $acc[$current] = ['order' => $key + 1];
                    return $acc;
                }, []);
                $variation->variableProductTypeAttributes()->sync($variation_attributes);
                $variation->load(["variableProductTypeAttributes" => fn ($query) => $query->_orderedByPivot()]);
                return compact('variation');
            case "create-variations-from-attributes":
                $current_variations = $product->variableTypeVariations()->with("variableProductTypeAttributes")->get();
                $attributes = $product->variableTypeAttributes()->_orderedByPivot()->with('pivot.values')->get();
                $attributes_with_values = [];
                foreach ($attributes as $attribute) {
                    $attributes_with_values[$attribute->id] = $attribute->pivot->values->pluck("id");
                }
                $attributes_cartesian_product = new CartesianProduct($attributes_with_values);
                $new_variations_count = 0;
                $new_variation_order = $product->variableTypeVariations()->count() + 1;
                foreach ($attributes_cartesian_product as $combination) {
                    if (!$current_variations->some(function ($variation) use ($combination) {
                        return $variation->variableProductTypeAttributes->every(fn ($attribute) => $attribute->pivot->attribute_value_id && $combination[$attribute->id] === $attribute->pivot->attribute_value_id);
                    })) {
                        $variation = $product->su()->create(["product_type" => "variable", "order" => $new_variation_order++]);
                        $variation_attributes = $attributes->pluck("id")->reduce(function ($acc, $current, $key) use ($combination) {
                            $acc[$current] = ['order' => $key + 1, 'attribute_value_id' => $combination[$current]];
                            return $acc;
                        }, []);
                        $variation->variableProductTypeAttributes()->sync($variation_attributes);
                        $new_variations_count++;
                    }
                }
                return compact('new_variations_count');
            case "remove-all-variations":
                $product->variableTypeVariations()->delete();
                return response()->_ok();
        }
    }
    public function postSaveChanges()
    {
        $req = request();
        $req->_trimDeep("variations.*.*", true);
        $variations = $req->input("variations");
        $errors = [];
        foreach ($variations as $variation) {
            $validated = ProductsValidations::variableTypeVariation($variation)->validate();
            if ($validated->failed) $errors[$variation["id"]] = $validated->exception->errors;
            if (collect($variations)->some(fn ($v) => $v["id"] !== $variation["id"] && collect($v["attributes"])->every(fn ($value, $key) => $variation["attributes"][$key] === $value))) {
                $errors[$variation["id"]]["attributes"] = "???????????? ???? ?????? ?????????? ???? ???????? ????????";
            }
        }
        if ($errors) _http_abort(422, $errors, HttpException::CTX_ERRORS);
        foreach ($variations as $key => $variation) {
            $su = ProductSu::find($variation["id"]);
            foreach ($variation["attributes"] as $attribute_id => $value_id) {
                $attribute =  $su->variableProductTypeAttributes()->wherePivot("attribute_id", $attribute_id)->first();
                $attribute->pivot->update(['attribute_value_id' => $value_id]);
            }
            $su->update([
                "price" => $price = $variation["price"],
                "discounted_price" => $discounted_price = $variation["discounted_price"],
                "discount_price" => $discount_price = $discounted_price ? $price - $discounted_price : null,
                "discount_percent" => $discount_price ? $discount_price * 100 / $price : null,
                "discount_expire" => $variation["discount_expire"],
                "sale_price" => $discounted_price ?: $price,
                "stock" => $stock = $variation["stock"],
                "is_active" => !is_null($stock) && !is_null($price) && collect($variation["attributes"])->every(fn ($value) => $value),
                "description" =>  $variation["description"],
                "order" =>  $key + 1,
            ]);
        }
        return response()->_ok();
    }
    public function deleteVariation($variation_id)
    {
        $variation = ProductSu::findOrFail($variation_id);
        $product = $variation->product()->first();
        $variation->delete();
        $product->variableTypeVariations()->_ordered()->get()->each(fn ($variation, $key) => $variation->update(["order" => $key + 1]));
        return response()->_ok();
    }
}
