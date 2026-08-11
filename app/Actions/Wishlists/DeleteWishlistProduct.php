<?php

declare(strict_types=1);

namespace App\Actions\Wishlists;

use App\Models\Product;
use App\Models\Wishlist;

final class DeleteWishlistProduct
{
    public function handle(Product $product): bool
    {
        return Wishlist::where('product_id', $product->id)->first()->delete();
    }
}
