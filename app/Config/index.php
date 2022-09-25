<?php

return [
    "resources" =>
    [
        "images" =>
        [
            "products" =>
            [
                "placeholder" =>
                [
                    "url" => "/public/storage/placeholders/product.png",
                ]
            ],
            "categories" =>
            [
                "placeholder" =>
                [
                    "url" => "/public/storage/placeholders/category.png",
                ]
            ],
            "users" =>
            [
                "placeholder" =>
                [
                    "url" => "/public/storage/placeholders/user.png",
                ]
            ],
            "brands" =>
            [
                "placeholder" => [
                    "url" => "https://via.placeholder.com/136x32.png",
                ]
            ],
            "logo" => [
                "placeholder" => [
                    "url" => "https://via.placeholder.com/200x40.png",
                ]
            ],
            "slideshow" => [
                "placeholder" => [
                    "desktop" => ["url" => "https://via.placeholder.com/1100x440"],
                    "mobile" => ["url" => "https://via.placeholder.com/510x395"]
                ]
            ]
        ]
    ],
    "mix" =>
    [
        // paths are relative to public folder
        "manifests" =>
        [
            "admin" => "/admin/dist",
            "main" => "/main/dist"
        ]
    ]
];
