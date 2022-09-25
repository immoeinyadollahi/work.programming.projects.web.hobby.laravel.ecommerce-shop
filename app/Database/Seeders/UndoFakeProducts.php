<?php

namespace App\Database\Seeders;

use Illuminate\Support\Facades\Storage;

use App\Classes\Base\Database\Seeder;
use App\Database\Models\Product;

class UndoFakeProducts extends Seeder
{
    public function run()
    {
        $products = Product::all();
        foreach ($products as $product) {
            // Thumbnails
            $thumbnails = $product->thumbnails()->get();
            foreach ($thumbnails as $thumbnail) {
                Storage::delete($thumbnail->path);
            }
            // Image
            $product->image()->_deleteFirst();
        }
    }
}
