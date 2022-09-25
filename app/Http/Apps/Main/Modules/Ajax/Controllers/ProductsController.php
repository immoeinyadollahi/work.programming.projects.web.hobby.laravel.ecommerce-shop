<?php

namespace App\Http\Apps\Main\Modules\Ajax\Controllers;

use App\Classes\Base\Routing\Controller;
use App\Database\Models\Product;

class ProductsController extends Controller
{
    public function getCompareProducts()
    {
        $req = request();
        $req->_trimAll();
        $term = $req->input("q");
        $comparable_product_ids = $req->input("comparable_products");
        if (is_null($term) || !is_string($term) || !($term = trim($term)) || !$comparable_product_ids) _http_abort(422);

        $searchable_categories = Product::whereIn("id", $comparable_product_ids)->with("mainCategory.comparableCategories")->get()->reduce(function ($acc, $current) {
            foreach ($current->mainCategory->comparableCategories as $comaprableCategory) {
                $pivot = $comaprableCategory->pivot;
                if (!$acc->contians($pivot->category_id_1)) {
                    $acc->add($pivot->category_id_1);
                }
                if (!$acc->contians($pivot->category_id_2)) {
                    $acc->add($pivot->category_id_2);
                }
            }
            return $acc;
        }, collect());

        $paginator = Product::select("products.*")->join("products_categories", fn ($join) => $join->on("products_categories.product_id", "products.id")->whereIn('products_categories.category_id', $searchable_categories))->withSelectedSu()->whereNotIn("products.id", $comparable_product_ids)->where("name", "LIKE", "%$term%")->_paginate(["page" => $req->query("page"), "limit" => 12]);
        return ["data" => $paginator, "html" => view("partials.compare-products", ["products" => $paginator->items])->render()];
    }
    public function getProductComments($product_id)
    {
        if (!($product = Product::published()->find($product_id))) _http_abort(404);
        $paginator = $product->comments()->with("user.profileImage")->where("is_verified", true)->latest()->_basePaginate();
        return ["data" => $paginator, "html" => view("shared::partials.product-comments", ["paginator" => $paginator])->render()];
    }
}
