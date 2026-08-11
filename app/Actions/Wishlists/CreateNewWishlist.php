<?php

declare(strict_types=1);

namespace App\Actions\Wishlists;

use App\Models\Product;
use App\Models\User;
use App\Models\Wishlist;

final readonly class CreateNewWishlist
{
    public function handle(Product $product, User $user): Wishlist
    {
        return Wishlist::firstOrCreate([
            'product_id' => $product->id,
            'user_id' => $user->id,
        ]);
    }
}
