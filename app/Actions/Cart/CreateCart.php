<?php

declare(strict_types=1);

namespace App\Actions\Cart;

use App\Models\Cart;
use App\Models\User;

final readonly class CreateCart
{
    public function handle(User $user): Cart
    {
        return Cart::firstOrCreate([
            'user_id' => $user->id,
        ]);
    }
}
