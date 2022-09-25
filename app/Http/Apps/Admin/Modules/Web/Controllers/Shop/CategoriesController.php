<?php

namespace App\Http\Apps\Admin\Modules\Web\Controllers\Shop;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use App\Classes\Base\Routing\Controller;
use App\Database\Models\Category;
use App\Database\Models\Image;

use App\Http\Apps\Admin\Validations\Shop\Categories as CategoriesValidations;

class CategoriesController extends Controller
{
    public function getCategories()
    {
        $paginator = Category::with("parent")->withCount("products")->latest()->_basePaginate(["limit" => 18]);
        return view("pages.shop.categories.categories-list", ["paginator" => $paginator]);
    }
    public function getCreateCategory()
    {
        // create auto draft category
        $category = Category::create();
        // all categories
        $categories = Category::orderBy("level")->get();
        return view("pages.shop.categories.edit-category", ["category" => $category, "categories" => $categories]);
    }
    public function getEditCategory($category_id)
    {
        if (!($category = Category::find($category_id))) _http_abort(404);
        // all categories
        $categories =  Category::orderBy("level")->get();
        return view("pages.shop.categories.edit-category", ["category" => $category, "categories" => $categories]);
    }
    public function postEditCategory($category_id)
    {
        if (!($category = Category::find($category_id))) _http_abort(404);
        $req = request();
        $req->_trimOnly(["en", "fa", "description"]);
        $validated = CategoriesValidations::category($req->input())->validate();
        if ($validated->failed) back()->_withValidationResult($validated)->withInput();
        $image_id = $req->input("image");
        $parent_id = $req->input("parent");
        $parent_category = $parent_id ? Category::find($parent_id) : null;
        $category->fill(array_merge($req->only("en", "fa", "description"), ["slug" => Str::slug($req->input("en")), "level" => $parent_category ? $parent_category->level + 1 : 0]));
        $category->save();
        $category_image = $category->image()->first();
        if ($image_id) {
            if ($category_image) {
                if ($category_image->id !== $image_id) {
                    // delete previous image
                    $category_image->is_default || Storage::delete($category_image->path);
                    $category_image->delete();

                    Image::where("id", $image_id)->_updateFirst("target_id", $category_id);
                }
            } else {
                Image::where("id", $image_id)->_updateFirst("target_id", $category_id);
            }
        } else if ($category_image) {
            if (!$category_image->is_default) {
                Storage::delete($category_image->path);
                $category_image->delete();
                // add default image to category
                $category_image->image()->create(["is_default" => true, "url" => _get_config("resources.images.categories.placeholder.url")]);
            }
        } else {
            // add default image to category
            $category->image()->create(["is_default" => true, "url" => _get_config("resources.images.categories.placeholder.url")]);
        }
        return back()->_withMessage("تغییرات ثبت شد", "success");
    }
    public function getDeleteCategory($category_id)
    {
        if (!($category = Category::with("image")->find($category_id))) _http_abort(404);
        $category->image->is_default || Storage::delete($category->image->path);
        $category->image->delete();
        $category->delete();
        return back()->_withMessage("دسته بندی با موفقیت حذف شد", "success");
    }
}
