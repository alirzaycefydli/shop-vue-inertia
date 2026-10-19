<?php

declare(strict_types=1);

namespace App\Actions\Payments;

use App\Actions\Orders\CreateOrder;
use App\Models\CartItem;
use App\Services\Stripe\StripePaymentService;
use Illuminate\Validation\ValidationException;
use Stripe\Checkout\Session;

final class CreateStripeCheckout
{
    public function __construct(
        private StripePaymentService $stripe,
        private CreateOrder $createOrderAction
    ) {}

    public function handle(array $items, string $addressId): Session
    {

        // Create the order and its items.
        $order = $this->createOrderAction->handle($items, $addressId);

        // Create Stripe Checkout session.
        $lineItems = $this->prepareStripeLineItems($items);

        $session = $this->stripe->createCheckoutSession($lineItems);

        $order->update([
            'session_id' => $session->id,
        ]);

        return $session;
    }

    public function prepareStripeLineItems(array $items): array
    {
        $quantities = collect($items)->mapWithKeys(
            fn (array $item) => [
                $item['id'] => $item['quantity'],
            ]
        );

        $cartItems = CartItem::query()
            ->whereIn('id', $quantities->keys())
            ->whereHas('cart', function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->with('product')
            ->get()
            ->keyBy('id');

        if ($cartItems->count() !== $quantities->count()) {
            throw ValidationException::withMessages([
                'items' => 'One or more cart items are invalid.',
            ]);
        }

        $lineItems = [];

        foreach ($quantities as $cartItemId => $quantity) {
            $cartItem = $cartItems->get($cartItemId);
            $product = $cartItem->product;

            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $product->name,
                        'images' => [$product->primaryImage()->first()->value('image_url')],
                    ],
                    'unit_amount' => (int) round(
                        $product->price * 100
                    ),
                ],
                'quantity' => $quantity,
            ];
        }

        return $lineItems;
    }
}
