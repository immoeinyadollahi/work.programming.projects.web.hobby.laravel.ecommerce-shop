<?php

namespace App\Http\Apps\Admin\Modules\Api\Controllers\Shop\Products;

use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

use App\Classes\Base\Routing\Controller;
use App\Database\Models\Product;
use App\Database\Models\Image as ImageModel;
use App\Database\Models\ProductThumbnail;

use App\Http\Apps\Admin\Validations\Shop\Products as ProductsValidations;

class MediaController extends Controller
{
    public function postImage()
    {
        $req = request();
        $validated = ProductsValidations::image($req->file())->validate();
        if ($validated->failed) return _http_abort(422, $validated);
        $image_file = $req->file("image");
        $file_path = "/shop/products/images/" . $image_file->hashName();
        Image::make($image_file)->resize(500, 500)->save(Storage::path($file_path));
        $image = ImageModel::create(["path" => $file_path, "url" => Storage::url($file_path), "original_name" => $image_file->getClientOriginalName(), "target_type" => Product::class]);
        return ["image_id" => $image->id, "image_url" => $image->url];
    }
    public function postThumbnail()
    {
        $req = request();
        $validated = ProductsValidations::thumbnail($req->file())->validate();
        if ($validated->failed) return _http_abort(422, $validated);
        $thumbnail_file = $req->file("thumbnail");
        $file_path = "/shop/products/thumbnails/" . $thumbnail_file->hashName();
        Image::make($thumbnail_file)->resize(200, 200)->save(Storage::path($file_path));
        $thumbnail = ProductThumbnail::create(["path" => $file_path, "url" => Storage::url($file_path), "original_name" => $thumbnail_file->getClientOriginalName()]);
        return ["thumbnail_id" => $thumbnail->id, "thumbnail_url" => $thumbnail->url];
    }
}
