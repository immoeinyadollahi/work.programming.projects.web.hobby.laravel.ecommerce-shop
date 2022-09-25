<?php

namespace App\Http\Apps\Admin\Modules\Api\Controllers\Settings;

use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

use App\Classes\Base\Routing\Controller;
use App\Settings\General as GeneralSettings;

use App\Http\Apps\Admin\Validations\Settings\Slideshow as SettingsSlideshowValidations;

class SlideshowController extends Controller
{
    public function postSlide(GeneralSettings $generalSettings)
    {
    }
    public function patchSlide(GeneralSettings $generalSettings, $slide_id)
    {
    }
    public function deleteSlide(GeneralSettings $generalSettings, $slide_id)
    {
    }
    public function postSlideImage(GeneralSettings $generalSettings)
    {
    }
}
