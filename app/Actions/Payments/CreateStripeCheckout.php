<?php

declare(strict_types=1);

namespace App\Actions\Payments;

use App\Actions\Checkout\GetCheckoutItems;
use App\Actions\Checkout\PrepareStripeLineItems;
use App\Actions\Orders\CreateOrder;
use App\Services\Stripe\StripePaymentService;
use Stripe\Checkout\Session;

final class CreateStripeCheckout
{
    public function __construct(
        private StripePaymentService $stripe,
        private CreateOrder $createOrderAction,
        private GetCheckoutItems $getCheckoutItems,
        private PrepareStripeLineItems $prepareStripeLineItems,
    ) {}

    public function handle(string $addressId): Session
    {
        // Create the order and its items.
        $items = $this->getCheckoutItems->handle();
        $order = $this->createOrderAction->handle($items, $addressId);

        // Create Stripe Checkout session.
        $lineItems = $this->prepareStripeLineItems->handle($items);
        $session = $this->stripe->createCheckoutSession($lineItems);

        $order->update([
            'session_id' => $session->id,
        ]);

        return $session;
    }
}
