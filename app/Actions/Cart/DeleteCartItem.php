<?php

declare(strict_types=1);

namespace App\Actions\Cart;

use App\Models\CartItem;

final readonly class DeleteCartItem
{
    public function handle(CartItem $cartItem): ?bool
    {
        return $cartItem->delete();
    }
}
