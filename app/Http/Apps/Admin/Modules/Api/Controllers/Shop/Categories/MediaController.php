<?php

namespace App\Http\Apps\Admin\Modules\Api\Controllers\Shop\Categories;

use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

use App\Classes\Base\Routing\Controller;
use App\Database\Models\Category;
use App\Database\Models\Image as ImageModel;

use App\Http\Apps\Admin\Validations\Shop\Categories as CategoriesValidations;

class MediaController extends Controller
{
    public function postImage()
    {
        $req = request();
        $validated = CategoriesValidations::image($req->file())->validate();
        if ($validated->failed) return _http_abort(422, $validated);
        $image_file = $req->file("image");
        $file_path = "/shop/categories/images/" . $image_file->hashName();
        Image::make($image_file)->resize(500, 500)->save(Storage::path($file_path));
        $image = ImageModel::create(["path" => $file_path, "url" => Storage::url($file_path), "original_name" => $image_file->getClientOriginalName(), "target_type" => Category::class]);
        return ["image_id" => $image->id, "image_url" => $image->url];
    }
}
