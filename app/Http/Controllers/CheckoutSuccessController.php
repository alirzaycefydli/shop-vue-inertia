<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Cart\DeleteAllCartItems;
use App\Actions\Cart\DeleteAllGuestCartItems;
use App\Enums\OrderStatus;
use App\Models\Order;
use Illuminate\Http\Request;
use Stripe\Exception\ApiErrorException;
use Stripe\StripeClient;

final class CheckoutSuccessController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, DeleteAllCartItems $deleteAllCartItems, DeleteAllGuestCartItems $deleteAllGuestCartItems)
    {
        $stripe = new StripeClient(config('services.stripe.secret'));

        $sessionId = $request->input('session_id');

        if (empty($sessionId)) {
            abort(404, 'Checkout session ID is missing.');
        }

        try {
            $session = $stripe->checkout->sessions->retrieve($sessionId);
        } catch (ApiErrorException $e) {
            abort(404, 'Checkout session not found.');
        }

        if ($session->payment_status !== 'paid') {
            abort(403, 'Payment has not been completed.');
        }

        $order = Order::where('session_id', $sessionId)
            ->first();
        if (! $order) {
            abort(404, 'Order not found.');
        }
        if ($order->status === OrderStatus::Pending->value) {
            $order->update([
                'status' => OrderStatus::Paid->value,
            ]);
        }

        if (auth()->user()) {
            $deleteAllCartItems->handle();
        } else {
            $deleteAllGuestCartItems->handle();
        }

        return inertia('Payment/Success');
    }
}
