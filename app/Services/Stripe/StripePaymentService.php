<?php

declare(strict_types=1);

namespace App\Services\Stripe;

use Stripe\Checkout\Session;
use Stripe\StripeClient;

final class StripePaymentService
{
    private StripeClient $stripe;

    public function __construct()
    {
        $this->stripe = new StripeClient(
            config('services.stripe.secret')
        );
    }

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
