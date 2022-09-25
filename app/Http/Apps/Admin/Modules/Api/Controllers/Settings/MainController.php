<?php

namespace App\Http\Apps\Admin\Modules\Api\Controllers\Settings;

use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

use App\Classes\Base\Routing\Controller;
use App\Database\Models\Temporary;

use App\Http\Apps\Admin\Validations\Settings\Main as SettingsMainValidations;

class MainController extends Controller
{
    public function postLogo()
    {
        $req = request();
        $validated = SettingsMainValidations::logo($req->file())->validate();
        if ($validated->failed) return _http_abort(422, $validated);
        $logo_file = $req->file("logo");
        $file_path = "/logos/" . $logo_file->hashName();
        Image::make($logo_file)->resize(500, 500)->save(Storage::path($file_path));
        $logo_url = Storage::url($file_path);
        $temporary = Temporary::create(["data" => ["url" => $logo_url, "path" => $file_path]]);
        return ["logo_temp_id" => $temporary->id, "logo_url" => $logo_url];
    }
}
