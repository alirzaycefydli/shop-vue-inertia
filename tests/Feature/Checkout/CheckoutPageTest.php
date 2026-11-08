<?php

declare(strict_types=1);

use App\Enums\ProductStatus;

test('guest user can access checkout page', function () {
    $product = createProduct(ProductStatus::Active->value);

    $this->post(route('cart.store', [
        'product' => $product->slug,
    ]));
    $response = $this->get(route('checkout.index'));

    $response->assertOk();
});

test('authenticated user can access checkout page', function () {
    $user = createTestUser();
    $product = createProduct(ProductStatus::Active->value);

    $this->actingAs($user)
        ->post(route('cart.store', [
            'product' => $product->slug,
        ]));
    $response = $this->actingAs($user)
        ->get(route('checkout.index'));

    $response->assertOk();
});

test('guest user`s cart contains correct products', function () {
    $product = createProduct(ProductStatus::Active->value);

    $this->post(route('cart.store', [
        'product' => $product->slug,
    ]));
    $response = $this->assertGuest()
        ->get(route('checkout.index'));

    $response->assertDatabaseHas();
})->todo();

test('authenticated user`s cart contains correct products', function () {
    $user = createTestUser();
    $product = createProduct(ProductStatus::Active->value);

    $this->actingAs($user)->post(route('cart.store', [
        'product' => $product->slug,
    ]));
    $this->actingAs($user)
        ->get(route('checkout.index'));

    $this->assertDatabaseHas('cart_items', [
        'product_id' => $product->id,
        'quantity' => 1,
        'cart_id' => $user->cart->id,
    ]);
});

test('guest user cannot checkout with empty cart and redirects to products page', function () {
    $this->get(route('checkout.index'))
        ->assertRedirect(route('products.index'));
});

test('authenticated user cannot checkout with empty cart and redirects to products page', function () {
    $user = createTestUser();

    $this->actingAs($user)
        ->get(route('checkout.index'))
        ->assertRedirect(route('products.index'));
});
