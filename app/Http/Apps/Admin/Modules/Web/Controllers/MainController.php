<?php

namespace App\Http\Apps\Admin\Modules\Web\Controllers;

use App\Classes\Base\Routing\Controller;
use App\Settings\General as GeneralSettings;
use App\Database\Models\Temporary;

class MainController extends Controller
{
    public function getIndex()
    {
        return view("pages.main.index");
    }
    public function getSettings(GeneralSettings $generalSettings)
    {
        return view("pages.main.settings", ["settings" => $generalSettings]);
    }
    public function postSettings(GeneralSettings $generalSettings)
    {
        $req = request();
        $req->_trimOnly(["address", "phone"]);
        $req->_trimDeep("social_media.*");
        $temp_logo = $req->input("temp_logo");
        $slideshow = $req->input("slideshow");
        if ($temp_logo) {
            $generalSettings->logo = Temporary::find($temp_logo)->data;
        }
        if (isset($slideshow->slides)) {
            $current_slideshow_slides = collect($generalSettings->slideshow["slides"]);
            $generalSettings->slideshow["slides"] = collect($slideshow->slides)->map(fn ($slide_id) => $current_slideshow_slides->first(fn ($slide) => $slide["id"] === $slide_id));
        }
        $generalSettings->fill(array_merge($req->only("website_name", "address", "phone", "social_media")));
        $generalSettings->save();
        return back()->_withMessage("تغییرات ثبت شد", "success");
    }
}
