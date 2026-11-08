<?php

declare(strict_types=1);
use App\Enums\ProductStatus;

test('can view the active product details', function () {
    $product = createProduct(ProductStatus::Active->value);

    $response = $this->get(route('products.show', $product->slug));

    $this->assertGuest();
    $response->assertOk();
});

test('inactive product cannot be viewed', function () {
    $product = createProduct(ProductStatus::Inactive->value);

    $response = $this->get(route('products.show', $product->slug));

    $response->assertNotFound();
});

test('non-existent product returns 404', function () {
    $response = $this->get(route('products.show', 'non-exist-slug'));

    $response->assertNotFound();
});
