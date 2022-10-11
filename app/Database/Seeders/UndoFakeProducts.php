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
            // image
            $product->image()->_deleteFirst();
            $product->delete();
        }
    }
}
