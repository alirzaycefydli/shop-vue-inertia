<?php

use App\Enums\ProductStatus;
use App\Models\Product;

test('add product to the cart', function () {
    $product = Product::factory()->create([
        'status' => ProductStatus::Active->value,
    ]);

    $response = $this->post(route('cart.store', [
        'product'=> $product->slug,
    ]));

    $response->assertOk()
        ->assertSessionHas('cart');
    $response->assertSessionHas('cart', function ($cart) use ($product) {
        return count($cart) === 1
            && $cart[0]['product_id'] === $product->id;
    });
});

test('increase product quantity', function(){
    $product = Product::factory()->create([
        'status' => ProductStatus::Active->value,
        'stock_quantity'=> 3,
    ]);

    $this->post(route('cart.store', [
        'product'=> $product->slug,
    ]));

    $response = $this->patch(route('cart.update', [
        'id'=> $product->id,
    ]), 
    [
        'quantity'=> 2,
    ]
    );

    $response->assertOk()
        ->assertSessionHas('cart', function($cart) use ($product){
            return count($cart) === 1
                && $cart[0]['product_id'] === $product->id
                && $cart[0]['quantity'] === 2;
        });
});

test('decrease product quantity', function(){
    $product = Product::factory()->create([
        'status' => ProductStatus::Active->value,
        'stock_quantity'=> 3,
    ]);

    for($i = 0; $i < 3; $i++){
        $this->post(route('cart.store', [
            'product'=> $product->slug,
        ]));
    }

    $response = $this->patch(route('cart.update', [
        'id'=> $product->id,
    ]),['quantity'=> 2]);

    $response->assertOk()
        ->assertSessionHas('cart', function($cart) use ($product){
            return count($cart) === 1
                && $cart[0]['product_id'] === $product->id
                && $cart[0]['quantity'] === 2;
        });
});

test('can remove a product', function(){
    $product = Product::factory()->create([
        'status' => ProductStatus::Active->value,
        'stock_quantity'=> 3,
    ]);

    $this->post(route('cart.store', [
        'product'=> $product->slug,
    ]));

    $response = $this->delete(route('cart.destroy', [
        'id'=> $product->id,
    ]));

    $response->assertOk()
        ->assertSessionHas('cart', function($cart){
            return count($cart) === 0;
        });
});

test('attempt to use an invalid quantity', function(){
    $product = Product::factory()->create([
        'status' => ProductStatus::Active->value,
        'stock_quantity'=> 1,
    ]);

    $this->post(route('cart.store', [
        'product'=> $product->slug,
    ]));
    $response = $this->patch(route('cart.update', [
        'id'=> $product->id,
    ]),['quantity'=> -1]);

    $response->assertOk()
        ->assertSessionHas('cart', function($cart){
            return count($cart) === 1;
        });
});

test('attempt to add a nonexistent product', function(){
    $response = $this->post(route('cart.store', [
        'product'=> 'nonexist-product-slug',
    ]));

    $response->assertNotFound()
        ->assertSessionMissing('cart');
});

test('attempt to exceed available stock', function(){
    $product = Product::factory()->create([
        'status' => ProductStatus::Active->value,
        'stock_quantity'=> 1,
    ]);

    $response = [];
    for($i = 0; $i < 2; $i++){
        $response =$this->post(route('cart.store', [
            'product'=> $product->slug,
        ]));
    }

    dd(session()->get('cart', []));
});

test('cannot add an inactive product', function(){})->todo();

test('cart data is retained through the session as intended', function(){})->todo();

test('empty cart is handled correctly', function(){})->todo();