<?php

namespace App\Http\Apps\Main\Modules\Api\Controllers;

use App\Classes\Base\Routing\Controller;
use App\Database\Models\Category;
use App\Database\Models\Product;

class CategoriesController extends Controller
{
    public function getProducts($category_id)
    {
        $category = Category::findOrFail($category_id);

        return ["paginator" => Product::aggregateByCategory($category)];
    }
}
