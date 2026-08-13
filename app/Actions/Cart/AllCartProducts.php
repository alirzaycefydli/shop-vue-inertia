<?php

declare(strict_types=1);

namespace App\Actions\Cart;

use App\Models\User;

final readonly class AllCartProducts
{
    public function __construct(private CreateCart $action) {}

    public function handle(User $user)
    {
        $cart = $user->cart;

        if (! $cart) {
            $this->action->handle($user);
        }

        return $cart->cartItem->map(function ($item) {
            return $item->load(['product', 'product.primaryImage']);
        });
    }
}
