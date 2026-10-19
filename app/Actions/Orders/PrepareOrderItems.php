<?php

declare(strict_types=1);

namespace App\Actions\Orders;

use App\Models\Product;
use Illuminate\Validation\ValidationException;

final class PrepareOrderItems
{
    public function handle(array $data)
    {
        $subtotal = 0;
        $items = [];

        foreach ($data as $item) {
            $product = Product::where('slug', $item['product']['slug'])->firstOrFail();

            if ($product->stock_quantity >= $item['quantity']) {
                $subtotal += $item['quantity'] * $product->price;
                $items[] = [
                    'quantity' => $item['quantity'],
                    'product' => $product,
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
