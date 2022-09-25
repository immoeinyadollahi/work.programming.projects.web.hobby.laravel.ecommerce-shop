<?php

namespace App\Http\Apps\Admin\Modules\Api\Controllers\Shop\Products;

use App\Classes\Base\Routing\Controller;
use App\Database\Models\Product;
use App\Database\Models\ProductSpecificationGroup;
use App\Database\Models\ProductSpecificationGroupItem;

use App\Http\Apps\Admin\Validations\Shop\Products as ProductsValidations;

class SpecificationsController extends Controller
{
    public function postGroup($product_id)
    {
        $req = request();
        $product = Product::find($product_id);
        if (!$product) _http_abort(404);
        $req->_trimOnly(["name"]);
        $name = $req->input("name");
        $validated = ProductsValidations::specificationGroup($req->input())->after(function ($errors) use ($product, $name) {
            if ($errors->has("name")) return;
            if ($product->specificationGroups()->where("name", $name)->exists()) $errors->add("name", "نام گروه نمی تواند تکراری باشد");
        })->validate();
        if ($validated->failed) _http_abort(422, $validated);
        $order = $product->specificationGroups()->count() + 1;
        $new_group = $product->specificationGroups()->create(["name" => $name, "order" => $order]);
        $new_group->items = [];
        return ["group" => $new_group];
    }
    public function postSaveOrdering()
    {
        $groups = request("groups");
        foreach ($groups as $key => $group) {
            ProductSpecificationGroup::where("id", $group["id"])->_updateFirst(["order" => $key + 1]);
            if (isset($group["items"]) && $group["items"]) {
                foreach ($group["items"] as $key => $item_id) {
                    ProductSpecificationGroupItem::where("id", $item_id)->_updateFirst(["order" => $key + 1]);
                }
            }
        }
        return response()->_ok();
    }
    public function patchGroup($group_id)
    {
        $req = request();
        $group = ProductSpecificationGroup::find($group_id);
        if (!$group) _http_abort(404);
        $product = $group->product()->first();
        $req->_trimOnly(["name"]);
        $name = $req->input("name");
        $validated = ProductsValidations::specificationGroup($req->input())->after(function ($errors) use ($product, $group, $name) {
            if ($errors->has("name") || $name === $group->name) return;
            if ($product->specificationGroups()->where("name", $name)->exists()) $errors->add("name", "نام گروه نمی تواند تکراری باشد");
        })->validate();
        if ($validated->failed) _http_abort(422, $validated);
        $group->name = $name;
        $group->save();
        return ["group" => $group];
    }
    public function deleteGroup($group_id)
    {
        $group = ProductSpecificationGroup::find($group_id);
        if (!$group) _http_abort(404);
        $product = $group->product()->first();
        $group->delete();
        $product_groups = $product->specificationGroups()->_ordered()->get();
        foreach ($product_groups as $key => $group) {
            $group->order = $key + 1;
            $group->save();
        }
        return response()->_ok();
    }
    public function postGroupItem($group_id)
    {
        $req = request();
        $group = ProductSpecificationGroup::find($group_id);
        if (!$group) _http_abort(404);
        $req->_trimOnly(["name", "value"]);
        $validated = ProductsValidations::specificationGroupItem($req->input())->after(function ($errors) use ($group, $req) {
            if (!$errors->has("name") && $group->items()->where("name", $req->input("name"))->exists()) $errors->add("name", "نام آیتم نمی تواند تکراری باشد");
            if (!$errors->hasAny("type", "value") && $req->input("type") === "boolean" && !in_array($req->input("value"), ["1", "0"])) $errors->add("value", "لطفا اطلاعات صحیح وارد کنید");
        })->validate();
        if ($validated->failed) _http_abort(422, $validated);
        $order = $group->items()->count() + 1;
        $new_item = $group->items()->create(array_merge(["order" => $order], $req->only("type", "value", "name")));
        return ["item" => $new_item];
    }
    public function patchGroupItem($item_id)
    {
        $req = request();
        $item = ProductSpecificationGroupItem::find($item_id);
        if (!$item) _http_abort(404);
        $group = $item->group()->first();
        $req->_trimOnly(["name"]);
        $validated = ProductsValidations::specificationGroupItem($req->input())->after(function ($errors) use ($group, $item, $req) {
            $name = $req->input("name");
            if (!$errors->has("name") && $req->input("name") !== $item->name && $group->items()->where("name", $name)->exists()) $errors->add("name", "نام آیتم نمی تواند تکراری باشد");
            if (!$errors->hasAny("type", "value") && $req->input("type") === "boolean" && !in_array($req->input("value"), ["1", "0"])) $errors->add("value", "لطفا اطلاعات صحیح وارد کنید");
        })->validate();
        if ($validated->failed) _http_abort(422, $validated);
        $item->fill($req->only("name", "value", "type"));
        $item->save();
        return ["item" => $item];
    }
    public function deleteGroupItem($item_id)
    {
        $item = ProductSpecificationGroupItem::find($item_id);
        if (!$item) _http_abort(404);
        $group = $item->group()->first();
        $item->delete();
        $group_items = $group->items()->_ordered()->get();
        foreach ($group_items as $key => $item) {
            $item->order = $key + 1;
            $item->save();
        }
        return response()->_ok();
    }
}
