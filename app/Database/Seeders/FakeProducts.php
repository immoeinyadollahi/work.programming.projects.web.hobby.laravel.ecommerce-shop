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
use Illuminate\Support\Facades\Log;

class FakeProducts extends Seeder
{
    public function run()
    {
        $products = ProductFactory::new()->count(10)->create();
        foreach ($products as $product) {
            $main_category = Category::where("en", "shirts")->first();
            // Brand
            $product->brand()->associate(Brand::where("en", "apple")->first())->save();
            // Tags
            $tags = TagFactory::new()->count(3)->state(["type" => Product::class])->create();
            foreach ($tags as $key => $tag) {
                $product->tags()->attach($tag->id, ["order" => $key + 1]);
            }
            // Thumbnails
            foreach (range(1, 5) as $order) {
                $product->thumbnails()->create(["url" => _get_config("resources.images.products.thumbnails.placeholder.url"), "order" => $order]);
            }
            // Image
            $product->image()->create(["is_default" => true, "url" => _get_config("resources.images.products.main.placeholder.url")]);
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
            // Properties
            foreach ($main_category->properties()->get()->map(fn ($property) => [$property->id, $property->pivot->values()->inRandomOrder()->first()->id]) as $key => [$property_id, $property_value_id]) {
                $product->properties()->attach($property_id, ["order" => $key + 1, "property_value_id" => $property_value_id]);
            }
            // Simple Type Su
            ProductSuFactory::new()->count(1)->state(["product_type" => "simple", "product_id" => $product->id])->create();
            // Variable Type Attributes
            $color_attribute = Attribute::where("en", "color")->first();
            $size_attribute = Attribute::where("en", "size")->first();
            $color_attribute_values = $color_attribute->values()->pluck("id");
            $size_attribute_values = $size_attribute->values()->pluck("id");

            $product->variableTypeAttributes()->attach([$color_attribute->id => ["order" => 1], $size_attribute->id => ["order" => 2]]);
            $product->variableTypeAttributes()->wherePivot("attribute_id", $color_attribute->id)->first()->pivot->values()->sync($color_attribute_values);
            $product->variableTypeAttributes()->wherePivot("attribute_id", $size_attribute->id)->first()->pivot->values()->sync($size_attribute_values);
            // Variable Type Variations
            $variations = ProductSuFactory::new()->count(4)->state(["product_type" => "variable", "product_id" => $product->id])->create();
            foreach ($variations as $key => $variation) {
                $variation->update(['order' => $key + 1]);
                $variation->variableProductTypeAttributes()->sync([$color_attribute->id => ["attribute_value_id" => $color_attribute_values[$key], "order" => 1], $size_attribute->id => ["attribute_value_id" => $size_attribute_values[$key], "order" => 2]]);
            }
        }
    }
}
