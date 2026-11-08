<?php

use App\Mail\Orders\OrderCreated;
use App\Models\Order;
use Illuminate\Support\Facades\Mail;
use Stripe\Checkout\Session;
use Stripe\WebhookSignature;

test('order is marked as paid after a successful Stripe webhook and order confirmation email is sent', function () {
    Mail::fake();

    $session = new Session([
        'id' => 'cs_test_123',
        'url' => 'https://checkout.stripe.com/test',
    ]);

    Order::factory()->create([
        'session_id' => $session->id,
    ]);

    $payload = json_encode([
        'id' => 'evt_test_webhook',
        'object' => 'event',
        'type' => 'checkout.session.completed',
        'data' => [
            'object' => [
                'id' => $session->id,
                'object' => 'checkout.session',
                'customer_details' => [
                    'email' => 'test@test.com',
                ]
            ],
        ],
    ], JSON_THROW_ON_ERROR);


    $signature = WebhookSignature::generateSignatureHeader(
        $payload,
        config('services.stripe.webhook'),
    );

    $response = $this->call(
        'POST',
        '/webhook',
        [],
        [],
        [],
        [
            'CONTENT_TYPE' => 'application/json',
            'HTTP_STRIPE_SIGNATURE' => $signature,
        ],
        $payload
    );
    
    $response->assertOk();
    $this->assertDatabaseHas('orders',[
        'session_id' => 'cs_test_123',
        'status' => 'paid',
        'email' => 'test@test.com',
    ]);
    Mail::assertQueued(OrderCreated::class);
});
