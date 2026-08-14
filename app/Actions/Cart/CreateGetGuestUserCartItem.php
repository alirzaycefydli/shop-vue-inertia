<?php

declare(strict_types=1);

namespace App\Actions\Cart;

use App\Models\Product;

final readonly class CreateGetGuestUserCartItem
{
    public function handle(Product $product): void
    {
        $cart = session()->get('cart', []);
        $item = array_find_key($cart, function ($value, $key) use ($product) {
            return $value['product_id'] === $product->id;
        });

        if ($item !== null && $product->stock_quantity > $cart[$item]['quantity']) {
            $cart[$item]['quantity'] += 1;
        } else {
            $cart[] = [
                'product_id' => $product->id,
                'quantity' => 1,
            ];
        }

        session()->put('cart', $cart);
    }
}
