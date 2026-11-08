<?php

declare(strict_types=1);

use App\Enums\ProductStatus;

test('products can be filtered by category', function () {
    $categoryOne = createProductCategory();
    $categoryTwo = createProductCategory();
    $productOne = createProduct(ProductStatus::Active->value, null, null, $categoryOne->id); // Product one
    createProduct(ProductStatus::Active->value, null, null, $categoryTwo->id); // Product two

    $response = $this->get(route('categories.index', [
        'category' => $categoryOne->slug,
    ]));

    $response->assertOk();

    $page = $response->viewData('page');
    $products = data_get($page, 'props.products.data');

    expect($products)->toHaveCount(1)
        ->and($products[0]['slug'])->toBe($productOne->slug);
});

test('products in child categories are included', function () {
    $mainCategory = createProductCategory();
    $subCategory = createProductCategory($mainCategory->id);
    createProduct(ProductStatus::Active->value, null, null, $subCategory->id);

    $response = $this->get(route('categories.index', [
        'category' => $mainCategory->slug,
    ]));

    $page = $response->viewData('page');
    $product = data_get($page, 'props.products.data');

    expect($product)->toHaveCount(1);
});

test('invalid category filter returns 404', function () {
    $response = $this->get(route('categories.index', ['category' => 'non-exist']));

    $response->assertNotFound();
});
