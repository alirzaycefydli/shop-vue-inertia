<?php

declare(strict_types=1);

namespace App\Actions\Orders;

use App\Enums\OrderStatus;
use App\Models\Order;

final class CreateOrder
{
    public function __construct(private CreateOrderItem $createOrderItemAction, private PrepareOrderItems $prepareOrderItemsAction) {}

    public function handle(array $data, string $addressId): Order
    {
        $orderItems = $this->prepareOrderItemsAction->handle($data);

        $order = Order::create([
            'user_id' => auth()->id() ?? null,
            'status' => OrderStatus::Pending->value,
            'subtotal' => $orderItems['subtotal'],
            'delivery' => 5,
            'total' => $orderItems['subtotal'] + 5,
            'currency' => 'USD',
            'shipping_address_id' => $addressId,
            'billing_address_id' => $addressId,
            'session_id' => null,
            'order_number' => $this->generateUniqueCode(),
        ]);

        foreach ($orderItems['items'] as $orderItem) {
            $this->createOrderItemAction->handle($orderItem['product'], $order->id, $orderItem['quantity']);
        }

        return $order;
    }

    private function generateUniqueCode(): int
    {
        do {
            $code = random_int(100000000, 999999999);
        } while (Order::where('order_number', $code)->exists());

        return $code;
    }
}
