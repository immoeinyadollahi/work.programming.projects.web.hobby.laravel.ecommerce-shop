<?php

namespace App\Http\Apps\Admin\Modules\Api\Controllers\Shop\Products\VariableType;

use BenTools\CartesianProduct\CartesianProduct;

use App\Classes\Base\Routing\Controller;
use App\Database\Models\ProductSu;
use App\Database\Models\Product;
use App\Database\Models\VariableProductSuAttribute;
use App\Exceptions\HttpException;

use App\Http\Apps\Admin\Validations\Shop\Products as ProductsValidations;

class VariationsController extends Controller
{
    public function getVariations($product_id)
    {
        if (!($product = Product::find($product_id))) _http_abort(404);
        $variations = $product->variableTypeVariations()->with(["variableProductTypeAttributePivots" => fn ($query) => $query->_ordered()])->_ordered()->get();
        return ["variations" => $variations];
    }
    public function getPerformAction($product_id, $action_name)
    {
        if (!($product = Product::find($product_id))) _http_abort(404);
        switch ($action_name) {
            case "create-variation":
                $variation_order = $product->variableTypeVariations()->count() + 1;
                $variation = $product->su()->create(["product_type" => "variable", "order" => $variation_order]);
                $attributes = $product->variableTypeAttributes()->_orderedByPivot()->get();
                foreach ($attributes as $attribute) {
                    $variation->variableProductTypeAttributePivots()->create(["order" => $attribute->pivot->order, "attribute_id" => $attribute->id]);
                }
                $variation->load(["variableProductTypeAttributePivots" => fn ($query) => $query->_ordered()]);
                return ["variation" => $variation];
            case "create-variations-from-attributes":
                $variations = $product->variableTypeVariations()->with("variableProductTypeAttributePivots")->get();
                $attributes = $product->variableTypeAttributes()->_orderedByPivot()->get();
                $attributes_values = [];
                foreach ($attributes as $attribute) {
                    $attributes_values[$attribute->id] = $attribute->pivot->values()->get()->map(fn ($value) => $value->id);
                }
                $attributes_cartesian_product = new CartesianProduct($attributes_values);
                $new_variations_count = 0;
                $new_variation_order = $product->variableTypeVariations()->count() + 1;
                foreach ($attributes_cartesian_product as $combination) {
                    if (!$variations->some(function ($variation) use ($combination) {
                        return $variation->variableProductTypeAttributePivots->every(fn ($attribute) => $attribute->attribute_value_id && $combination[$attribute->id] === $attribute->attribute_value_id);
                    })) {
                        $variation = $product->su()->create(["product_type" => "variable", "order" => $new_variation_order++]);
                        $new_variations_count++;
                        foreach ($attributes as $attribute) {
                            $variation->variableProductTypeAttributePivots()->create(["order" => $attribute->pivot->order, "attribute_id" => $attribute->id, "attribute_value_id" => $combination[$attribute->en]]);
                        }
                    }
                }
                return ["new_variations_count" => $new_variations_count];
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
                $errors[$variation["id"]]["attributes"] = "متغیری با این ویژگی ها وجود دارد";
            }
        }
        if ($errors) _http_abort(422, $errors, HttpException::CTX_ERRORS);
        foreach ($variations as $key => $variation) {
            foreach ($variation["attributes"] as $attribute_id => $value_id) {
                VariableProductSuAttribute::where(["product_su_id" => $variation["id"], "attribute_id" => $attribute_id])->_updateFirst(["attribute_value_id" => $value_id]);
            }
            ProductSu::where("id", $variation["id"])->_updateFirst([
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
        if (!($variation = ProductSu::find($variation_id))) _http_abort(404);
        $product = $variation->product()->first();
        $variation->delete();
        $variations = $product->variableTypeVariations()->_ordered()->get();
        foreach ($variations as $key => $variation) {
            $variation->order = $key + 1;
            $variation->save();
        }
        return response()->_ok();
    }
}
