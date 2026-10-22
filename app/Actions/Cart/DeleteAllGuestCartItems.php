<?php

declare(strict_types=1);

namespace App\Actions\Cart;

final class DeleteAllGuestCartItems
{
    public function handle(): void
    {
        session()->forget('cart');
    }
}
