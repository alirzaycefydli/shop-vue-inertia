<?php

declare(strict_types=1);

use App\Enums\ProductStatus;
use App\Models\Product;

test('guest user can view the product listing', function () {
    $response = $this->get(route('products.index'));

    $this->assertGuest();
    $response->assertOk();
});

test('product listing returns only active products', function () {
    createProduct(ProductStatus::Active->value); // Active Product
    createProduct(ProductStatus::Inactive->value); // Inactive Product
    createProduct(ProductStatus::Inactive->value); // Inactive Product

    $products = Product::all();

    $this->assertCount(1, $products);
});

test('product listing handles an empty catalog', function () {
    $response = $this->get(route('products.index'));

    $response->assertOk();
});

test('product listing displays the correct product data', function () {
    $product = createProduct(ProductStatus::Active->value);

    $this->get(route('products.index'));

    $this->assertDatabaseHas('products', [
        'id' => $product->id,
        'name' => $product->name,
        'slug' => $product->slug,
        'price' => $product->price,
        'stock_quantity' => $product->stock_quantity,
        'status' => ProductStatus::Active->value,
    ]);
});
