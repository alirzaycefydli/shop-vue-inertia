<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Wishlists\AllWishlistProducts;
use App\Actions\Wishlists\CreateNewWishlist;
use App\Actions\Wishlists\DeleteWishlistProduct;
use App\Models\Product;
use Inertia\Inertia;

final class WishlistController extends Controller
{
    public function show(AllWishlistProducts $action)
    {
        return Inertia::render('Wishlist/Show', [
            'products' => $action->handle(auth()->user()),
        ]);

    }

    public function store(Product $product, CreateNewWishlist $action): void
    {
        $wishlist = $action->handle($product, auth()->user());

        if ($wishlist->wasRecentlyCreated) {
            session()->flash('messages', ['type' => 'success', 'message' => 'Product successfully added to your wishlist!']);
        } else {
            session()->flash('messages', ['type' => 'warning', 'message' => 'Product is already in your wishlist!']);
        }
    }

    public function destroy(Product $product, DeleteWishlistProduct $action)
    {
        if ($action->handle($product)) {
            session()->flash('messages', ['type' => 'success', 'message' => 'Product successfully deleted from your wishlist!']);
        } else {
            session()->flash('messages', ['type' => 'error', 'message' => 'Something went wrong! Please try again later.']);
        }
    }
}
