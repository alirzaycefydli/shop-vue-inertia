<?php

declare(strict_types=1);

namespace App\Actions\Wishlists;

use App\Http\Resources\ProductCardResource;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Pagination\LengthAwarePaginator;

final class AllWishlistProducts
{
    public function handle(User $user): LengthAwarePaginator
    {
        $wishlists = Wishlist::where('user_id', $user->id)
            ->with('product.primaryImage')
            ->paginate();

        return $wishlists->through(function ($wishlist) {
            return ProductCardResource::make($wishlist->product);
        });
    }
}
