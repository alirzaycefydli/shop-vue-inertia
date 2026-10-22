<?php

declare(strict_types=1);

namespace App\Actions\Checkout;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Validation\ValidationException;

final class GetCheckoutItems
{
    public function handle(): array
    {
        if (auth()->check()) {
            return $this->getAuthenticatedUserItems();
        }

        return $this->getGuestItems();
    }

    private function getAuthenticatedUserItems(): array
    {
        $cartItems = CartItem::query()
            ->whereHas('cart', function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->with('product')
            ->get();

        return $cartItems->map(function (CartItem $cartItem) {
            return [
                'product' => $cartItem->product,
                'quantity' => (int) $cartItem->quantity,
            ];
        })->all();
    }

    private function getGuestItems(): array
    {
        $sessionItems = session('cart', []);

        if (empty($sessionItems)) {
            return [];
        }

        $quantities = collect($sessionItems)->mapWithKeys(
            fn (array $item) => [
                $item['product_id'] => (int) $item['quantity'],
            ]
        );

        $products = Product::query()
            ->whereIn('id', $quantities->keys())
            ->get()
            ->keyBy('id');

        if ($products->count() !== $quantities->count()) {
            throw ValidationException::withMessages([
                'cart' => 'One or more products in your cart are no longer available.',
            ]);
        }

        return $quantities->map(
            fn (int $quantity, string $productId) => [
                'product' => $products->get($productId),
                'quantity' => $quantity,
            ]
        )->values()->all();
    }
}
