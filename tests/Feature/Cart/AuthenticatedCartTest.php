<?php

use App\Enums\ProductStatus;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\User;

test('can add protuct to the cart', function () {
    $product = Product::factory()->create([
        'status' => ProductStatus::Active->value,
    ]);
    $user = User::factory()->create();

    $response = $this->actingAs($user)
        ->post(route('cart.store', [
            'product' => $product->slug,
        ]));

    $response->assertOk();
    $this->assertDatabaseCount('cart_items', 1)->
        assertDatabaseHas('cart_items', [
            'product_id' => $product->id,
            'quantity' => 1,
        ]);
});

test('can increase product quantity', function () {
    $product = Product::factory()->create([
        'status' => ProductStatus::Active->value,
        'stock_quantity' => 3,
    ]);
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('cart.store', [
            'product' => $product->slug,
        ]));

    $userCart = Cart::where('user_id', $user->id)->first();
    $cartItem = CartItem::where('cart_id', $userCart->id)->first();

    $response = $this->patch(
        route('cart.update', [
            'id' => $cartItem->id,
        ]),
        [
            'quantity' => 3,
        ]
    );

    $response->assertOk();
    $this->assertDatabaseCount('cart_items', 1)->
        assertDatabaseHas('cart_items', [
            'product_id' => $product->id,
            'quantity' => 3,
            'cart_id'=> $userCart->id
        ]);
});

test('can decrease product quantity', function () {
    $product = Product::factory()->create([
        'status' => ProductStatus::Active->value,
        'stock_quantity' => 3,
    ]);
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('cart.store', [
            'product' => $product->slug,
        ]));

    $userCart = Cart::where('user_id', $user->id)->first();
    $cartItem = CartItem::where('cart_id', $userCart->id)->first();

    $this->patch(
        route('cart.update', [
            'id' => $cartItem->id,
        ]),
        [
            'quantity' => 2,
        ]
    );
    $response = $this->patch(
        route('cart.update', [
            'id' => $cartItem->id,
        ]),
        [
            'quantity' => 1,
        ]
    );

    $response->assertOk();
    $this->assertDatabaseCount('cart_items', 1)->
        assertDatabaseHas('cart_items', [
            'product_id' => $product->id,
            'quantity' => 1,
            'cart_id'=> $userCart->id
        ]);
});

test('can remove a product', function () {
    $product = Product::factory()->create([
        'status' => ProductStatus::Active->value,
        'stock_quantity' => 3,
    ]);
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('cart.store', [
            'product' => $product->slug,
        ]));

    $userCart = Cart::where('user_id', $user->id)->first();
    $cartItem = CartItem::where('cart_id', $userCart->id)->first();

    $response = $this->delete(route('cart.destroy', [
        'id' => $cartItem->id,
    ]));

    $response->assertOk();
    $this->assertDatabaseEmpty('cart_items');
});

test('cart data belongs to the authenticated user', function () {
    $product = Product::factory()->create([
        'status' => ProductStatus::Active->value,
        'stock_quantity' => 3,
    ]);
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('cart.store', [
            'product' => $product->slug,
        ]));

    $userCart = Cart::where('user_id', $user->id)->first();

    $this->assertDatabaseHas('cart_items', [
        'cart_id' => $userCart->id,
    ]);
});

test('user cannot modify another user`s cart.', function () {
    $product = Product::factory()->create([
        'status' => ProductStatus::Active->value,
        'stock_quantity' => 3,
    ]);
    $userOne = User::factory()->create();
    $userTwo = User::factory()->create();

    $this->actingAs($userOne)
        ->post(route('cart.store', [
            'product' => $product->slug,
        ]));

    $userOneCart = Cart::where('user_id', $userOne->id)->first();
    $userOneCartItem = CartItem::where('cart_id', $userOneCart->id)->first();

    $response = $this->actingAs($userTwo)->patch(
        route('cart.update', [
            'id' => $userOneCartItem->id,
        ]),
        [
            'quantity' => 2,
        ]
    );

    $response->assertForbidden();
    $this->assertDatabaseHas('cart_items', [
        'id' => $userOneCartItem->id,
        'quantity' => 1,
    ]);
});

test('attempt to use an invalid quantity', function () {
    $product = Product::factory()->create([
        'status' => ProductStatus::Active->value,
        'stock_quantity' => 3,
    ]);
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('cart.store', [
            'product' => $product->slug,
        ]));

    $userCart = Cart::where('user_id', $user->id)->first();
    $cartItem = CartItem::where('cart_id', $userCart->id)->first();

    $response = $this->patch(
        route('cart.update', [
            'id' => $cartItem->id,
        ]),
        [
            'quantity' => -1,
        ]
    );

    $response->assertOk();
    $this->assertDatabaseHas('cart_items',[
        'quantity' => 1
    ]);
});

test('attempt to add a nonexistent product', function () { })->todo();

test('attempt to exceed available stock', function () { })->todo();

test('cannot add an inactive product', function () { })->todo();

test('empty cart returns empty and do not throw errors', function () { })->todo();
