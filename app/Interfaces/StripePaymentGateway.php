<?php

namespace App\Interfaces;

use Stripe\Checkout\Session;

interface StripePaymentGateway
{
    public function createCheckoutSession(array $lineItems): Session;
}
