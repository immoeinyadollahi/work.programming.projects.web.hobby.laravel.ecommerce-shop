<?php

namespace App\Database\Seeders;

use Illuminate\Support\Facades\Storage;

use App\Classes\Base\Database\Seeder;
use App\Database\Models\Category;
use App\Database\Models\Attribute;
use App\Database\Models\Brand;
use App\Database\Models\Product;
use App\Database\Factories\ProductSpecificationGroupFactory;
use App\Database\Factories\ProductSpecificationGroupItemFactory;
use App\Database\Factories\ProductCommentFactory;
use App\Database\Factories\ProductSuFactory;
use App\Database\Factories\ProductFactory;
use App\Database\Factories\TagFactory;

class FakeProducts extends Seeder
{
    public function run()
    {
        $products = ProductFactory::new()->count(10)->create();
        foreach ($products as $product) {
            $main_category = Category::where("en", "shirts")->first();
            // Brand
            $product->brand()->associate(Brand::where("en", "apple")->first());
            // Tags
            $tags = TagFactory::new()->count(3)->state(["type" => Product::class])->create();
            foreach ($tags as $key => $tag) {
                $product->tags()->attach($tag->id, ["order" => $key + 1]);
            }
            // Thumbnails
            foreach (range(1, 5) as $key => $value) {
                $thumbnail_file_name = "product-$value.jpg";
                $thumbnail_file_path = "/shop/products/thumbnails/test/" . $thumbnail_file_name;
                $product->thumbnails()->create(["path" => $thumbnail_file_path, "url" => Storage::url($thumbnail_file_path), "original_name" => $thumbnail_file_name, "order" => $key + 1]);
            }
            // Image
            $product->image()->create(["is_default" => true, "url" => _get_config("resources.images.products.placeholder.url")]);
            // Categories
            $create_categories =  function ($category) use (&$create_categories, $product) {
                $product->categories()->attach($category->id);
                $category->parent_id && $create_categories($category->parent()->first());
            };
            $create_categories($main_category);
            // Specification Groups
            $specification_groups = ProductSpecificationGroupFactory::new()->count(8)->state(["product_id" => $product->id])->make();
            foreach ($specification_groups as $key => $group) {
                $group->order = $key + 1;
                $group->save();
                $group_items = ProductSpecificationGroupItemFactory::new()->count(10)->state(["group_id" => $group->id])->make();
                foreach ($group_items as $key => $item) {
                    $item->order = $key + 1;
                    $item->save();
                }
            }
            // Comments
            ProductCommentFactory::new()->count(38)->state(["user_id" => 1, "product_id" => $product->id])->create();
            // Simple Type Su
            ProductSuFactory::new()->count(1)->state(["product_type" => "simple", "product_id" => $product->id])->create();

            // Properties
            foreach ($main_category->properties()->get()->map(fn ($property) => $property->pivot->values()->inRandomOrder()->first()) as $key => $property_value) {
                $product->properties()->attach($property_value->id, ["order" => $key + 1, "property_id" => $property_value->property_id]);
            }
            // Variable Type Attributes
            $color_attribute = Attribute::where("en", "color")->first();
            $size_attribute = Attribute::where("en", "size")->first();
            $color_attribute_values = $color_attribute->values()->get();
            $size_attribute_values = $size_attribute->values()->get();

            $product->variableTypeAttributes()->attach([$color_attribute->id => ["order" => 1], $size_attribute->id => ["order" => 2]]);
            foreach ($product->variableTypeAttributes()->get() as $attribute) {
                $attribute->pivot->values()->attach(collect($attribute->en === "color" ? $color_attribute_values : $size_attribute_values)->map(fn ($value) => $value->id));
            }
            // Variable Type Su
            $variable_type_su = ProductSuFactory::new()->count(4)->state(["product_type" => "variable", "product_id" => $product->id])->create();
            foreach ($variable_type_su as $key => $su) {
                $su->order = $key + 1;
                $su->save();
                $su->variableProductTypeAttributes()->sync([$color_attribute_values[$key]->id => ["attribute_id" => $color_attribute->id, "order" => 1], $size_attribute_values[$key]->id => ["attribute_id" => $size_attribute->id, "order" => 2]]);
            }
        }
    }
}
