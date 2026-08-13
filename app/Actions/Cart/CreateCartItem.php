<?php

declare(strict_types=1);

namespace App\Actions\Cart;

use App\Models\CartItem;
use App\Models\Product;
use App\Models\User;

final readonly class CreateCartItem
{
    public function __construct(private CreateCart $action) {}

    public function handle(Product $product, User $user): CartItem
    {
        $cart = $this->action->handle($user);

        $cartItem = CartItem::updateOrCreate([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
        ]);

        if (! $cartItem->wasRecentlyCreated) {
            $cartItem->quantity = $cartItem->quantity + 1;
            $cartItem->save();
        }

        return $cartItem;
    }
}
