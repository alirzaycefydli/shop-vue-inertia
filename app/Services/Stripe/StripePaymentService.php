<?php

declare(strict_types=1);

namespace App\Services\Stripe;

use App\Interfaces\StripePaymentGateway;
use Stripe\Checkout\Session;
use Stripe\StripeClient;

final class StripePaymentService implements StripePaymentGateway
{
    public function __construct(private StripeClient $stripe) {}

    public function createCheckoutSession(array $lineItems): Session
    {
        return $this->stripe->checkout->sessions->create([
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('checkout.success', [], true).'?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('checkout.cancel', [], true),
        ]);
    }
}
