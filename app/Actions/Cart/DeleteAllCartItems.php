<?php

declare(strict_types=1);

namespace App\Actions\Cart;

use App\Models\Cart;
use App\Models\CartItem;

final class DeleteAllCartItems
{
    public function handle(): void
    {
        $cart = Cart::where('user_id', auth()->id())->first();

        if ($cart) {
            $items = CartItem::where('cart_id', $cart->id)->get();

            foreach ($items as $item) {
                $item->delete();
            }
        }
    }
}
