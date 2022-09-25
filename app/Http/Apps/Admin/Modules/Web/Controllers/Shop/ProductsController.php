<?php

namespace App\Http\Apps\Admin\Modules\Web\Controllers\Shop;

use Illuminate\Database\Eloquent\Collection;

use App\Classes\Base\Routing\Controller;
use App\Database\Models\Category;
use App\Database\Models\Product;
use App\Database\Models\Attribute;
use App\Database\Models\Brand;

class ProductsController extends Controller
{
    public function getProducts()
    {
        $products = Product::get();
        return view("pages.shop.products.products-list", ["products" => $products]);
    }
    public function getCreateProduct()
    {
        // create auto draft product
        $product = Product::create();
        // show draft status instead of auto-draft but only for client
        $product->status = "draft";
        // create default product simple su
        $simple_su = $product->su()->create(["product_type" => "simple"]);
        // default values
        $product->thumbnails = [];
        $product->tags = [];
        $product->categories = [];
        $product->main_category = null;
        $product->specification_groups = [];
        $product->properties = [];
        $product->simple_type = ["su" => $simple_su];
        $product->variable_type = ["variations" => [], "attributes" => []];
        // categories tree
        $categories = Category::getTree();
        return view("pages.shop.products.edit-product", compact('product', "categories"));
    }
    public function getEditProduct($product_id)
    {
        $product = Product::findOrFail($product_id);
        // brand
        $product->brand = $product->brand()->first();
        // image
        $product->image = $product->image()->where("is_default", false)->first();
        // thumbnails
        $product->thumbnails = $product->thumbnails()->_ordered()->get();
        // tags
        $product->tags = $product->tags()->_orderedByPivot()->get();
        // categories
        $product->categories = $product->categories()->orderBy("level")->get();
        // main category
        $product->main_category = $product->getMainCategoryWithRelatedData();
        // specifications
        $product->specification_groups = $product->specificationGroups()->_ordered()->with(["items" => fn ($query) => $query->_ordered()])->get();
        // properties
        $product->properties = $product->properties()->with("property")->_orderedByPivot()->get();
        // simple type
        $product->simple_type = ["su" => $product->simpleTypeSu()->first()];
        // variable type
        $product->variable_type = ["variations" => $product->variableTypeVariations()->with(["variableProductTypeAttributePivots" => fn ($query) => $query->_ordered()])->get(), "attributes" => $product->variableTypeAttributePivots()->with("values")->_ordered()->get()];
        // categories tree
        $categories = Category::getTree();
        return view("pages.shop.products.edit-product", compact('product', "categories"));
    }
}
