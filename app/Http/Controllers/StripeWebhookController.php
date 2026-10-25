<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Orders\SendOrderConfirmationEmail;
use App\Enums\OrderStatus;
use App\Models\Order;
use Illuminate\Http\Request;
use Stripe\Event;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Webhook;

final class StripeWebhookController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, SendOrderConfirmationEmail $sendOrderConfirmationEmail)
    {
        $endpoint_secret = config('services.stripe.webhook');

        $payload = @file_get_contents('php://input');
        $event = null;

        try {
            $event = Event::constructFrom(
                json_decode($payload, true)
            );
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            return response('Webhook error while parsing basic request.', 400);
        }

        if ($endpoint_secret) {
            // Only verify the event if there is an endpoint secret defined
            // Otherwise use the basic decoded event
            $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
            try {
                $event = Webhook::constructEvent(
                    $payload, $sig_header, $endpoint_secret
                );
            } catch (SignatureVerificationException $e) {
                // Invalid signature
                return response('Webhook error while validating signature.', 400);
            }
        }

        // Handle the event
        switch ($event->type) {
            case 'checkout.session.completed':
                $session = $event->data->object;

                $order = Order::with(['orderItems.product.primaryImage'])
                    ->where('session_id', $session->id)
                    ->first();

                if ($order && $order->status === OrderStatus::Pending->value) {
                    $order->update([
                        'status' => OrderStatus::Paid->value,
                        'email' => $session->customer_details->email,
                    ]);

                    $sendOrderConfirmationEmail->handle($order);
                }
                break;
        }

        return response('', 200);
    }
}
