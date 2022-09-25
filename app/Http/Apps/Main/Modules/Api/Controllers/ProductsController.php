<?php

namespace App\Http\Apps\Main\Modules\Api\Controllers;

use App\Classes\Base\Routing\Controller;
use App\Database\Models\Product;

class ProductsController extends Controller
{
    public function getSearch()
    {
        $req = request();
        $term = $req->query("q");
        if (is_null($term) || !is_string($term)) _http_abort(404);
        $term = trim($term);

        return ["paginator" => Product::aggregateBySearch($term)];
    }
    public function getQuickviewProduct($product_id)
    {
        $user = _user();
        if (!($product = Product::published()->find($product_id))) _http_abort(404);
        // Image
        $product->image = $product->image()->first();
        // Thumbnails
        $product->thumbnails = $product->thumbnails()->_ordered()->get();
        // Tags
        $product->tags = $product->tags()->_orderedByPivot()->get();
        // Su
        if ($product->is_variable) {
            $variations = $product->variableTypeVariations()->with(["variableProductTypeAttributes" => fn ($query) => $query->_orderedByPivot()])->active()->inStock()->_ordered()->get();
            $product->variable_type = (object)["variations" => $variations, "selected_variation_id" => $variations->count() ? $product->variableTypeVariations()->active()->inStock()->orderByRaw("sale_price,stock desc")->first("id")->id : null, "attributes" => $product->variableTypeAttributes()->_orderedByPivot()->get()];
        } else {
            // Simple Type Su
            $su = $product->simpleTypeSu()->active()->inStock()->first();
            $product->simple_type = (object) ["su" => $su];
        }
        $product->is_user_favourite = $user && $product->favoredByUsers()->where("users.id", $user->id)->exists();
        return ["product" => $product];
    }
}
