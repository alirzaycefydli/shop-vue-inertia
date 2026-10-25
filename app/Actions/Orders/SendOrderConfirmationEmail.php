<?php

declare(strict_types=1);

namespace App\Actions\Orders;

use App\Mail\Orders\OrderCreated;
use App\Models\Order;
use Illuminate\Support\Facades\Mail;

final class SendOrderConfirmationEmail
{
    public function handle(Order $order): void
    {
        Mail::to($order->email)
            ->queue(new OrderCreated($order));
    }
}
