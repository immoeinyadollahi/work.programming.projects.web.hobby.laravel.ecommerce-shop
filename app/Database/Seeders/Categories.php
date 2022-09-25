<?php

namespace App\Database\Seeders;

use App\Classes\Base\Database\Seeder;
use App\Database\Models\Category;

class Categories extends Seeder
{
    public function run()
    {
        $categories =
            [
                [
                    "en" => "electronic-devices",
                    "fa" => "کالای دیجیتال",
                    "slug" => "electronic-devices",
                    "children" =>
                    [

                        [
                            "en" => "mobile-phone",
                            "fa" => "گوشی موبایل",
                            "slug" => "mobile-phone",
                            "children" =>
                            [
                                [
                                    "en" => "sony",
                                    "fa" => "سونی",
                                    "slug" => "sony",
                                ],
                                [
                                    "en" => "apple",
                                    "fa" => "اپل",
                                    "slug" => "apple",
                                ],
                                [
                                    "en" => "honor",
                                    "fa" => "آنر",
                                    "slug" => "honor",
                                ],
                            ]
                        ],
                        [
                            "en" => "mobile-accessories",
                            "fa" => "لوازم جانبی موبایل",
                            "slug" => "mobile-accessories",
                        ],
                    ]
                ],
                [
                    "en" => "apparel",
                    "fa" => "مد و پوشاک",
                    "slug" => "apparel",
                    "children" =>
                    [

                        [
                            "en" => "men-clothing",
                            "fa" => "لباس مردانه",
                            "slug" => "men-clothing",
                            "children" =>
                            [
                                [
                                    "en" => "shirts",
                                    "fa" => "پیراهن",
                                    "slug" => "shirts",
                                ],
                            ]
                        ]
                    ]
                ]
            ];
        $create_categories = function ($categories, $level = 1, $parent_id = null) use (&$create_categories) {
            foreach ($categories as $category) {
                $category_children = $category["children"] ?? null;
                unset($category["children"]);
                $category["level"] = $level;
                $category["is_last_level"] = !$category_children;
                $category["parent_id"] = $parent_id;
                $new_category = Category::create($category);
                $new_category->image()->create(["is_default" => true, "url" => _get_config("resources.images.categories.placeholder.url")]);
                if ($category_children) $create_categories($category_children, $level + 1, $new_category->id);
            }
        };
        $create_categories($categories);
    }
}
