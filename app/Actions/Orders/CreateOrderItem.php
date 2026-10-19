<?php

declare(strict_types=1);

namespace App\Actions\Orders;

use App\Models\OrderItem;
use App\Models\Product;

final class CreateOrderItem
{
    public function handle(Product $product, string $orderId, int $quantity): OrderItem
    {
        return OrderItem::create([
            'order_id' => $orderId,
            'product_id' => $product->id,
            'product_name' => $product->name,
            'quantity' => $quantity,
            'unit_price' => $product->price,
            'subtotal' => $product->price * $quantity,
        ]);
    }
}
