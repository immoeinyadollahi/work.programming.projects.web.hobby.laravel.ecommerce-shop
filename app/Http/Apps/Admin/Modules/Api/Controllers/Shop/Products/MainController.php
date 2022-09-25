<?php

namespace App\Http\Apps\Admin\Modules\Api\Controllers\Shop\Products;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use App\Classes\Base\Routing\Controller;
use App\Database\Models\Category;
use App\Database\Models\Product;
use App\Database\Models\Image as ImageModel;
use App\Database\Models\ProductThumbnail;
use App\Database\Models\Tag;

use App\Http\Apps\Admin\Validations\Shop\Products as ProductsValidations;

class MainController extends Controller
{
    public function patchProduct($product_id)
    {
        $req = request();
        $product = Product::find($product_id);
        if (!$product) _http_abort(404);
        $image_id = $req->input("image");
        $thumbnails = $req->input("thumbnails", []);
        $tags = $req->input("tags", []);
        $req->_trimOnly(["name", "description"]);
        $validated = ProductsValidations::product($req->input())->validate();
        if ($validated->failed) _http_abort(422, $validated);
        // set image
        $product_image = $product->image()->first();
        if ($image_id) {
            if ($product_image) {
                if ($product_image->id !== $image_id) {
                    // delete previous image
                    $product_image->is_default || Storage::delete($product_image->path);
                    $product_image->delete();

                    ImageModel::where("id", $image_id)->_updateFirst("target_id", $product_id);
                }
            } else {
                ImageModel::where("id", $image_id)->_updateFirst("target_id", $product_id);
            }
        } else if ($product_image) {
            if (!$product_image->is_default) {
                Storage::delete($product_image->path);
                $product_image->delete();
                // add default image to product
                $product->image()->create(["is_default" => true, "url" => _get_config("resources.images.products.placeholder.url")]);
            }
        } else {
            // add default image to product
            $product->image()->create(["is_default" => true, "url" => _get_config("resources.images.products.placeholder.url")]);
        }

        // set thumbnails
        $deleted_product_thumbnails = $thumbnails ? $product->thumbnails()->whereNotIn("id", $thumbnails)->get() : $product->thumbnails()->get();
        foreach ($deleted_product_thumbnails as $thumbnail) {
            Storage::delete($thumbnail->path);
            $thumbnail->delete();
        }
        if ($thumbnails) {
            foreach ($thumbnails as $key => $thumbnail) {
                ProductThumbnail::where("id", $thumbnail)->_updateFirst(["order" => $key + 1, "product_id" => $product_id]);
            }
        }
        // set tags
        $tag_ids = [];
        if ($tags) {
            foreach ($tags as $key => $tag_name) {
                $order = $key + 1;
                $tag = Tag::where([["name", $tag_name], ["type" => "product"]])->first();
                if (!$tag) {
                    $tag = Tag::create(["type" => "product", "name" => $tag_name, "slug" => Str::slug($tag_name)]);
                }
                $tag_ids[] = [$tag->id => ["order" => $order]];
            }
        }
        $product->tags()->sync($tag_ids);
        $product->fill(array_merge($req->only("name", "status", "type", "description", 'brand_id'), ["slug" => Str::slug($req->input("name"))]));
        $product->save();
        return response()->_ok();
    }
    public function patchCategory($product_id)
    {
        $req = request();
        $product = Product::findOrFail($product_id);
        // new_category will become main category of product
        $new_category = Category::findOrFail($req->input("category_id"));
        $add_categories = function ($category) use (&$add_categories, $product) {
            $product->categories()->attach($category->id);
            if ($category->parent_id) {
                $add_categories($category->parent()->first());
            }
        };
        $current_main_category = $product->mainCategory()->first();
        if ($current_main_category) {
            if ($current_main_category->id !== $new_category->id) {
                if ($product->brand_id && !$new_category->brands()->where("brands.id", $product->brand_id)->exists()) {
                    $product->brand()->disassociate();
                }
                $product->variableTypeVariations()->delete();
                $product->variableTypeAttributes()->detach();
                $product->properties()->detach();
                $product->categories()->detach();
                $add_categories($new_category);
            }
        } else {
            $add_categories($new_category);
        }
        $categories = $product->categories()->orderBy("level")->get();
        $main_category = $product->getMainCategoryWithRelatedData();
        return compact('categories', 'main_category');
    }
}
