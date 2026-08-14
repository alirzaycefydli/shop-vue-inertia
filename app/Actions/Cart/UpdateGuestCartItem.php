<?php

declare(strict_types=1);

namespace App\Actions\Cart;

use App\Models\Product;

final readonly class UpdateGuestCartItem
{
    public function handle(string $product_id, int $quantity): void
    {
        $cart = session()->get('cart', []);
        $product = Product::find($product_id);

        if ($quantity > 0 && $product && $product->stock_quantity >= $quantity) {
            $index = array_find_key($cart, function ($value) use ($product) {
                return $value['product_id'] === $product->id;
            });

            if ($index !== null) {
                $cart[$index]['quantity'] = $quantity;
                session()->put('cart', $cart);
            }
        }
    }
}
