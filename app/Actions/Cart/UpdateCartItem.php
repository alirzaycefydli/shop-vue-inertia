<?php

declare(strict_types=1);

namespace App\Actions\Cart;

use App\Models\CartItem;

final readonly class UpdateCartItem
{
    public function handle(CartItem $cartItem, int $quantity): bool
    {
        if($quantity > 0){
            return $cartItem->update([
                'quantity' => $quantity,
            ]);
        }
        return false;
    }
}
