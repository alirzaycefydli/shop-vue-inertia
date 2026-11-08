<?php

use App\Actions\Orders\CreateOrder;
use App\Actions\Orders\CreateOrderItem;
use App\Actions\Orders\PrepareOrderItems;
use App\Enums\OrderStatus;
use App\Enums\ProductStatus;
use App\Models\Order;
use App\Models\OrderItem;

use function PHPSTORM_META\type;

test('can create order successfully', function () {
    $order = createOrder();
    $this->assertDatabaseCount('orders', 1)
        ->assertDatabaseHas('orders', [
            'user_id' => null,
            'id' => $order->id,
            'order_number' => $order->order_number,
        ]);
});

test('order items created successfully', function () {
    $order = createOrder();

    $this->assertDatabaseCount('order_items', 1)
        ->assertDatabaseHas('order_items',[
            'order_id' => $order->id,
        ]);
});

test('order items retrieved correctly', function () {
    $user = createTestUser();
    $order = Order::factory()->create([
        'user_id' => $user->id,
    ]);
    $orderItems = OrderItem::factory(2)->create([
        'order_id' => $order->id,
    ]);
    
    expect($orderItems->toArray())
        ->toHaveCount(2)
        ->toMatchArray($order->orderItems->toArray());
});

test('subtotal price calculated correctly', function () {
    $data = [
        [
            'product' => createProduct(ProductStatus::Active->value, 3, 100.99),
            'quantity' => 2,
        ]
    ];
    $orderItems = new PrepareOrderItems();
    $items = $orderItems->handle($data);

    expect($items)
        ->toHaveCount(2)
        ->toHaveKeys(['subtotal', 'items'])
        ->and($items['subtotal'])
        ->toBe(201.98);
});

test('total price calculated correctly', function () {
    $order = createOrder([
        [
            'status' => ProductStatus::Active->value,
            'stock_quantity' => 10,
            'price' => 25.50,
            'quantity' => 2,
        ],
        [
            'status' => ProductStatus::Active->value,
            'stock_quantity' => 5,
            'price' => 40.00,
            'quantity' => 3,
        ],
    ]);

    expect($order->subtotal)->toBe(171.00)
        ->and($order->delivery)->toBe(5)
        ->and($order->total)->toBe(176.00);
});

test('order status saved as pending once order is created', function () {
    $order = createOrder();

    expect($order->status)
        ->toBe(OrderStatus::Pending->value);
});

test('order assigned to correct user', function () {
    $user = createTestUser();
    $this->actingAs($user);
    $order = createOrder();

    expect($order->user_id)
        ->toBe($user->id);
});

test('guest user`s order assigned correctly', function () {
    $order = createOrder();

    expect($order->user_id)
        ->toBe(null);
});

test('user cannot use another user`s address', function () {})->todo();

test('checkout handles missing or invalid address', function () {})->todo();

test('invalid quantities and unavailable stock cannot be purchased', function () {})->todo();
