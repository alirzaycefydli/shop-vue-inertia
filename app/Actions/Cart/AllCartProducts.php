<?php

declare(strict_types=1);

namespace App\Actions\Cart;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

final readonly class AllCartProducts
{
    public function __construct(private CreateCart $action) {}

    /**
     * @return Collection<int, CartItem>
     */
    public function handle(User $user): Collection
    {
        /** @var Cart $cart */
        $cart = $user->cart ?? $this->action->handle($user);

        return $cart->cartItem->map(function ($item) {
            return $item->load(['product', 'product.primaryImage']);
        });
    }
}
