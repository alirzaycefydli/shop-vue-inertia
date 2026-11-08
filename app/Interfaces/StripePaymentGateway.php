<?php

declare(strict_types=1);

namespace App\Interfaces;

use Stripe\Checkout\Session;

interface StripePaymentGateway
{
    public function createCheckoutSession(array $lineItems): Session;
}
