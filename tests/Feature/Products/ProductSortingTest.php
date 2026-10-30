<?php

use App\Enums\ProductStatus;
use App\Models\Product;

test('invalid sorting option falls back safely', function(){
    $response = $this->get(route('products.index',[
        'sort' => 'non-exist',
    ]));

    $response->assertOk()
        ->assertSessionHasNoErrors();
});


test('active product scope returns only active products', function () {
    Product::factory()->create([ 
        'status' => ProductStatus::Active->value, // Active product
    ]);
    Product::factory()->create([
        'status' => ProductStatus::Inactive->value, // Inactive product
    ]);

    $products = Product::all();

    expect($products)
        ->toHaveCount(1)
        ->and($products->first()->status->value)
        ->toBe(ProductStatus::Active->value);
});