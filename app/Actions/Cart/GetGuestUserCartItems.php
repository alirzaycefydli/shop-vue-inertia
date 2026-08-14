<?php

declare(strict_types=1);

namespace App\Actions\Cart;

use App\Http\Resources\ProductCardResource;
use App\Models\Product;
use Illuminate\Support\Collection;

final readonly class GetGuestUserCartItems
{
    public function handle(): Collection
    {
        $cart = session()->get('cart', []);
        $products = Product::whereIn('id', collect($cart)->pluck('product_id'))->get();

        return collect($cart)->map(function ($item) use ($products) {
            $product = $products->find($item['product_id']);

            return [
                'id' => $product->id,
                'quantity' => $item['quantity'],
                'product_quantity' => $product->stock_quantity,
                'product' => ProductCardResource::make($product),
            ];
        });
    }
}
