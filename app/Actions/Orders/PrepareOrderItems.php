<?php

declare(strict_types=1);

namespace App\Actions\Orders;

use Illuminate\Validation\ValidationException;

final class PrepareOrderItems
{
    public function handle(array $data)
    {
        $subtotal = 0;
        $items = [];

        foreach ($data as $item) {
            if ($item['product']->stock_quantity >= $item['quantity']) {
                $subtotal += $item['quantity'] * $item['product']->price;
                $items[] = [
                    'quantity' => $item['quantity'],
                    'product' => $item['product'],
                ];
            } else {
                ValidationException::withMessages([
                    'quantity' => 'Sorry! The product has insufficient stock.',
                ]);
            }
        }

        return [
            'subtotal' => $subtotal,
            'items' => $items,
        ];
    }
}
