<?php

declare(strict_types=1);

namespace App\Actions\Cart;


final class DeleteGuestCartItem
{
    public function handle(string $product_id): void
    {

        $cart = session()->get('cart', []);

        $index = array_find_key($cart, function ($value) use ($product_id) {
            return $value['product_id'] === $product_id;
        });

        if ($index !== null) {
            unset($cart[$index]);
            $cart = array_values($cart);
            session()->put('cart', $cart);
        }
    }
}
