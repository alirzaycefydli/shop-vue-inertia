<?php

declare(strict_types=1);

namespace App\Actions\Cart;

use App\Models\CartItem;

final readonly class UpdateCartItem
{
    public function handle(CartItem $cartItem, int $quantity): bool
    {
        return $cartItem->update([
            'quantity' => $quantity,
        ]);
    }
}
