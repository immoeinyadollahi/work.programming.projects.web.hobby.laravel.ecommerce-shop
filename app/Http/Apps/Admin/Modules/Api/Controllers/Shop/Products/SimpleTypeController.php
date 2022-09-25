<?php

namespace App\Http\Apps\Admin\Modules\Api\Controllers\Shop\Products;

use App\Classes\Base\Routing\Controller;
use App\Database\Models\Product;

use App\Http\Apps\Admin\Validations\Shop\Products as ProductsValidations;

class SimpleTypeController extends Controller
{
    public function patchSu($product_id)
    {
        $req = request();
        if (!($product = Product::find($product_id))) _http_abort(404);
        $su = $product->simpleTypeSu()->first();
        $req->_trimAll(true);
        $validated = ProductsValidations::simpleTypeSu($req->input())->validate();
        if ($validated->failed) _http_abort(422, $validated);
        $su->fill([
            "price" => $price = $req->input("price"),
            "discounted_price" => $discounted_price = $req->input("discounted_price"),
            "discount_price" => $discount_price = $discounted_price ? $price - $discounted_price : null,
            "discount_percent" => $discount_price ? $discount_price * 100 / $price : null,
            "discount_expire" => $req->input("discount_expire"),
            "sale_price" => $discounted_price ?: $price,
            "stock" => $stock = $req->input("stock"),
            "is_active" => !is_null($stock) && !is_null($price),
            "description" =>  $req->input("description"),
        ]);
        $su->save();
        return ["su" => $su];
    }
}
