<?php

use App\Services\Stripe\StripePaymentService;
use Stripe\StripeClient;
use Stripe\StripeClientInterface;
use Stripe\Checkout\Session;
use Stripe\Service\Checkout\CheckoutServiceFactory;
use Stripe\Service\Checkout\SessionService;

test('stripe session retrieved', function () {
    
    $session = $this->createMock(Session::class);

    $sessionService = $this->createMock(SessionService::class);
    
    $sessionService->expects($this->once())
        ->method('create')
        ->willReturn($session);
    
    $stripeClient = $this->getMockBuilder(StripeClient::class)
        ->disableOriginalConstructor()
        ->onlyMethods(['getService'])
        ->getMock();

    $checkoutFactory = new class($stripeClient, $sessionService) extends CheckoutServiceFactory {
        public function __construct(
            StripeClientInterface $client,
            private SessionService $sessionService,
        ) {
            parent::__construct($client);
        }

        public function __get($name)
        {
            if ($name === 'sessions') {
                return $this->sessionService;
            }

            return parent::__get($name);
        }
    };


    $stripeClient->expects($this->once())
        ->method('getService')
        ->with('checkout')
        ->willReturn($checkoutFactory);

    $service = new StripePaymentService($stripeClient);

    $result = $service->createCheckoutSession([
        ['price' => 'price_test', 'quantity' => 1],
    ]);

    expect($result)->toBe($session);
});


