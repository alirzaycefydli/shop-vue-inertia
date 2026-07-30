<?php

declare(strict_types=1);

use App\Enums\ProductStatus;

return [

    'categories' => [

        [
            'name' => 'Electronics',
            'slug' => 'electronics',
            'children' => [

                [
                    'name' => 'Computers',
                    'slug' => 'computers',
                    'children' => [

                        [
                            'name' => 'Laptops',
                            'slug' => 'laptops',
                        ],

                        [
                            'name' => 'Desktop Computers',
                            'slug' => 'desktop-computers',
                        ],
                    ],
                ],

                [
                    'name' => 'Smartphones',
                    'slug' => 'smartphones',
                ],

                [
                    'name' => 'Accessories',
                    'slug' => 'electronics-accessories',
                ],
                [
                    'name'=>'Gaming Consoles',
                    'slug'=>'gaming-consoles'
                ]
            ],
        ],

        [
            'name' => 'Photography',
            'slug' => 'photography',
            'children' => [

                [
                    'name' => 'Digital Cameras',
                    'slug' => 'digital-cameras',
                ],

                [
                    'name' => 'Lenses',
                    'slug' => 'lenses',
                ],
                [
                    'name' => 'Instant Cameras',
                    'slug' => 'instant-cameras',
                ],
            ],
        ],

        [
            'name' => 'Home Appliances',
            'slug' => 'home-appliances',
            'children' => [

                [
                    'name' => 'Refrigerators',
                    'slug' => 'refrigerators',
                ],

                [
                    'name' => 'Washing Machines',
                    'slug' => 'washing-machines',
                ],
            ],
        ],
    ],

    'products' => [

        [
            'name' => 'MacBook Pro 14',
            'slug' => 'macbook-pro-14',
            'description' => 'Professional laptop with powerful performance.',
            'detailed_description' => 'Apple MacBook Pro with high resolution display and powerful processor.',
            'price' => 1999.99,
            'stock_quantity' => 25,
            'status' => ProductStatus::Active->value,

            'categories' => [
                'laptops',
            ],

            'images' => [
                [
                    'image_url' => 'https://picsum.photos/200/300',
                    'position' => 0,
                ],
                [
                    'image_url' => 'https://picsum.photos/200/300',
                    'position' => 1,
                ],
                [
                    'image_url' => 'https://picsum.photos/200/300',
                    'position' => 2,
                ],
            ],
        ],
        [
            'name' => 'MacBook Air 12',
            'slug' => 'macbook-air-12',
            'description' => 'Professional laptop with powerful performance.',
            'detailed_description' => 'Apple MacBook Air with high resolution display and powerful processor.',
            'price' => 999.99,
            'stock_quantity' => 15,
            'status' => ProductStatus::Draft->value,

            'categories' => [
                'laptops',
            ],

            'images' => [
                [
                    'image_url' => 'https://picsum.photos/200/300',
                    'position' => 0,
                ],
            ],
        ],

        [
            'name' => 'iPhone 16 Pro',
            'slug' => 'iphone-16-pro',
            'description' => 'Latest generation smartphone.',
            'detailed_description' => 'Premium smartphone with advanced camera system.',
            'price' => 1199.99,
            'stock_quantity' => 50,
            'status' => ProductStatus::Active->value,

            'categories' => [
                'smartphones',
            ],

            'images' => [
                [
                    'image_url' => 'https://picsum.photos/200/300',
                    'position' => 0,
                ],
                [
                    'image_url' => 'https://picsum.photos/200/300',
                    'position' => 1,
                ],
                [
                    'image_url' => 'https://picsum.photos/200/300',
                    'position' => 2,
                ],
                [
                    'image_url' => 'https://picsum.photos/200/300',
                    'position' => 3,
                ],
                [
                    'image_url' => 'https://picsum.photos/200/300',
                    'position' => 4,
                ],
            ],
        ],

        [
            'name' => 'Gaming PC RTX 5070',
            'slug' => 'gaming-pc-rtx-5070',
            'description' => 'High performance gaming desktop.',
            'detailed_description' => 'Desktop computer designed for modern AAA gaming.',
            'price' => 2499.99,
            'stock_quantity' => 10,
            'status' => ProductStatus::Active->value,

            'categories' => [
                'desktop-computers',
                'gaming',
            ],

            'images' => [
                [
                    'image_url' => 'https://picsum.photos/200/300',
                    'position' => 0,
                ],
                [
                    'image_url' => 'https://picsum.photos/200/300',
                    'position' => 1,
                ],
                [
                    'image_url' => 'https://picsum.photos/200/300',
                    'position' => 2,
                ],
            ],
        ],

        [
            'name' => 'PlayStation 5 Pro',
            'slug' => 'playstation-5-pro',
            'description' => 'Next generation gaming console.',
            'detailed_description' => 'Powerful gaming console with improved graphics.',
            'price' => 699.99,
            'stock_quantity' => 30,
            'status' => ProductStatus::Active->value,

            'categories' => [
                'gaming-consoles',
            ],

            'images' => [
                [
                    'image_url' => 'https://picsum.photos/200/300',
                    'position' => 0,
                ],
                [
                    'image_url' => 'https://picsum.photos/200/300',
                    'position' => 1,
                ],
                [
                    'image_url' => 'https://picsum.photos/200/300',
                    'position' => 2,
                ],
            ],
        ],

        [
            'name' => 'Wireless Gaming Mouse',
            'slug' => 'wireless-gaming-mouse',
            'description' => 'Low latency gaming mouse.',
            'detailed_description' => 'Ergonomic mouse designed for competitive gaming.',
            'price' => 89.99,
            'stock_quantity' => 100,
            'status' => ProductStatus::Active->value,

            'categories' => [
                'gaming-accessories',
                'electronics-accessories',
            ],

            'images' => [
                [
                    'image_url' => 'https://picsum.photos/200/300',
                    'position' => 0,
                ],
                [
                    'image_url' => 'https://picsum.photos/200/300',
                    'position' => 1,
                ],
            ],
        ],

        [
            'name' => 'Fujifilm Instax Mini 12',
            'slug' => 'fujifilm-Instax-Mini-12',
            'description' => 'The Instax Mini 12 instant camera is designed to make mini prints in the size of 86 mm x 54 mm.',
            'detailed_description' => 'The Instax Mini 12 instant camera is designed to make mini prints in the size of 86 mm x 54 mm. Thanks to the characteristic white frame, they resemble classic photographs from retro instant cameras.',
            'price' => 29.99,
            'stock_quantity' => 200,
            'status' => ProductStatus::Active->value,

            'categories' => [
                'instant-cameras',
            ],

            'images' => [
                [
                    'image_url' => 'https://picsum.photos/200/300',
                    'position' => 0,
                ],
                [
                    'image_url' => 'https://picsum.photos/200/300',
                    'position' => 1,
                ],
                [
                    'image_url' => 'https://picsum.photos/200/300',
                    'position' => 2,
                ],
            ],
        ],

    ],
];
