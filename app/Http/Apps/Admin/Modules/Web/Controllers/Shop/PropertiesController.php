<?php

namespace App\Http\Apps\Admin\Modules\Web\Controllers\Shop;

use App\Classes\Base\Routing\Controller;
use App\Database\Models\Property;
use App\Database\Models\PropertyGroup;

use App\Http\Apps\Admin\Validations\Shop\Properties as PropertiesValidations;

class PropertiesController extends Controller
{
    public function getGroups()
    {
        $paginator = PropertyGroup::latest()->_basePaginate(["limit" => 18]);
        return view("pages.shop.properties.groups-list", ["paginator" => $paginator]);
    }
    public function getCreateGroup()
    {
        return view("pages.shop.properties.create-group");
    }
    public function postCreateGroup()
    {
        $req = request();
        $req->_trimOnly("name");
        $validated = PropertiesValidations::group($req->input())->validate();
        if ($validated->failed) return back()->_withValidationResult($validated)->withInput();
        PropertyGroup::create($req->only("name"));
        return redirect("/shop/property-groups")->_withMessage("گروه جدید ایجاد شد", "success");
    }
    public function getEditGroup($group_id)
    {
        if (!($group = PropertyGroup::find($group_id))) _http_abort(404);
        return view("pages.shop.properties.edit-group", ["group" => $group]);
    }
    public function postEditGroup($group_id)
    {
        $req = request();
        $req->_trimOnly("name");
        if (!($group = PropertyGroup::find($group_id))) _http_abort(404);
        $validated = PropertiesValidations::group($req->input())->validate();
        if ($validated->failed) return back()->_withValidationResult($validated)->withInput();
        $group->fill($req->only("name"));
        $group->save();
        return back()->_withMessage("تغییرات ثبت شد", "success");
    }
    public function getDeleteGroup($group_id)
    {
        if (!PropertyGroup::where("id", $group_id)->_deleteFirst()) _http_abort(404);
        return back()->_withMessage("گروه با موفقیت حذف شد", "success");
    }
    public function getGroupProperties($group_id)
    {
        if (!($group = PropertyGroup::find($group_id))) _http_abort(404);
        $paginator = $group->properties()->withCount("values")->latest()->_basePaginate(["limit" => 18]);
        return view("pages.shop.properties.properties-list", ["paginator" => $paginator, "group" => $group]);
    }
    public function getCreateProperty($group_id)
    {
        if (!($group = PropertyGroup::find($group_id))) _http_abort(404);
        return view("pages.shop.properties.create-property", ["group" => $group]);
    }
    public function postCreateProperty($group_id)
    {
        $req = request();
        $req->_trimDeep(["values.*", "name"], true);
        if (!($group = PropertyGroup::find($group_id))) _http_abort(404);
        $validated = PropertiesValidations::property($req->input())->validate();
        if ($validated->failed) return back()->_withValidationResult($validated)->withInput();
        $values = collect($req->input("values", []))->filter(fn ($value) => !is_null($value));
        $property = $group->properties()->create(["name" => $req->input("name")]);
        $property->values()->createMany($values->map(fn ($value) => ["value" => $value]));
        return redirect("/shop/property-group/$group_id/properties")->_withMessage("ویژگی جدید ایجاد شد", "success");
    }
    public function getEditProperty($property_id)
    {
        if (!($property = Property::with("values")->find($property_id))) _http_abort(404);
        return view("pages.shop.properties.edit-property", ["property" => $property]);
    }
    public function postEditProperty($property_id)
    {
        $req = request();
        $req->_trimDeep(["values.*", "name"], true);
        if (!($property = Property::find($property_id))) _http_abort(404);
        $validated = PropertiesValidations::property($req->input())->validate();
        if ($validated->failed) return back()->_withValidationResult($validated)->withInput();
        $values = collect($req->input("values", []))->filter(fn ($value) => !is_null($value));
        $property->name = $req->input("name");
        $property->save();
        if ($values) {
            $property->values()->whereNotIn("value", $values)->delete();
            foreach ($values as $value) {
                if (!$property->values()->where("value", $value)->exists()) {
                    $property->values()->create(["value" => $value]);
                }
            }
        } else {
            $property->values()->delete();
        }
        return back()->_withMessage("تغییرات ثبت شد", "success");
    }
    public function getDeleteProperty($property_id)
    {
        if (!Property::where("id", $property_id)->_deleteFirst()) _http_abort(404);
        return back()->_withMessage("ویژگی با موفقیت حذف شد", "success");
    }
}
