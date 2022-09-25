<?php

namespace App\Database\Models;

use App\Classes\Base\Database\Model;

class Category extends Model
{
    public static $orderable = "sibling_order";

    protected $table = 'categories';

    public static function getTree($parent_id = null)
    {
        $tree = [];
        $categories = self::where("parent_id", $parent_id)->_ordered()->get();
        if ($categories) {
            foreach ($categories as $category) {
                $category->children = self::getTree($category->id);
                $tree[] = $category;
            }
        }
        return $tree;
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, ProductCategoryX::class)->withTimestamps();
    }
    public function image()
    {
        return $this->morphOne(Image::class, 'target');
    }
    public function parent()
    {
        return $this->belongsTo(Category::class, "parent_id");
    }
    public function children()
    {
        return $this->hasMany(Category::class, "parent_id");
    }
    public function brands()
    {
        return $this->belongsToMany(Brand::class, CategoryBrandX::class)->withTimestamps();
    }
    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, CategoryAttributeX::class)->withTimestamps()->withPivot("id");
    }
    public function properties()
    {
        return $this->belongsToMany(Property::class, CategoryPropertyX::class)->withTimestamps()->withPivot("id");
    }
}
