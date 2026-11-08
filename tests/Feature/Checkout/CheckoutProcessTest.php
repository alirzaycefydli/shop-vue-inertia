<?php

use App\Actions\Payments\CreateStripeCheckout;
use App\Interfaces\StripePaymentGateway;
use Stripe\Checkout\Session;

test('creates an order and stripe checkout session successfully', function(){

    $session = new Session([
        'id' => 'cs_test_123',
        'url' => 'https://checkout.stripe.com/test',
    ]);

    $this->mock(StripePaymentGateway::class)
        ->expects('createCheckoutSession')
        ->once()
        ->andReturn($session);

    $action = app(CreateStripeCheckout::class);
    $address = createAddress();

    $result = $action->handle($address->id);

    $this->assertDatabaseHas('orders', [
        'session_id' => 'cs_test_123',
    ]);

    expect($result->id)->toBe('cs_test_123');
});