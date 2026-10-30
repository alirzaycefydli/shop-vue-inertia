<?php

use App\Enums\ProductStatus;
use App\Models\Category;
use App\Models\Product;

test('products can be filtered by category', function () {
    $categoryOne = Category::factory()->create();
    $categoryTwo = Category::factory()->create();
    $productOne = Product::factory()->create([
        'primary_category_id' => $categoryOne->id, // Product one
        'status' => ProductStatus::Active->value,
    ]);
    Product::factory()->create([
        'primary_category_id' => $categoryTwo->id, // Product two
        'status' => ProductStatus::Active->value,
    ]);

    $response = $this->get(route('categories.index', [
        'category' => $categoryOne->slug,
    ]));

    $response->assertOk();

    $page = $response->viewData('page');
    $products = data_get($page, 'props.products.data');

    expect($products)->toHaveCount(1)
        ->and($products[0]['slug'])->toBe($productOne->slug);
});

test('products in child categories are included', function(){
    $mainCategory = Category::factory()->create();
    $subCategory = Category::factory()->create([
        'parent_id' => $mainCategory->id,
    ]);
    Product::factory()->create([
        'primary_category_id'=> $subCategory->id,
        'status' => ProductStatus::Active->value,
    ]);

    $response = $this->get(route('categories.index', [
        'category' => $mainCategory->slug,
    ]));

    $page = $response->viewData('page');
    $product = data_get($page, 'props.products.data');

    expect($product)->toHaveCount(1);
});

test('invalid category filter returns 404', function(){
    $response = $this->get(route('categories.index', ['category' => 'non-exist']));

    $response->assertNotFound();
});