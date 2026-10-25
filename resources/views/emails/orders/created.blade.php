<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
</head>
<body style="margin: 0; padding: 24px; background-color: #f4f4f5; font-family: Arial, sans-serif; color: #18181b;">

    <table role="presentation" width="100%" cellspacing="0" cellpadding="0">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellspacing="0" cellpadding="0"
                    style="max-width: 600px; width: 100%; background-color: #ffffff; border-radius: 8px;">

                    <tr>
                        <td style="padding: 32px;">
                            <h1 style="margin: 0 0 12px; font-size: 24px;">
                                Thank you for your order!
                            </h1>

                            <p style="color: #52525b; line-height: 1.6;">
                                Your payment was successful and your order has been confirmed.
                            </p>

                            <p style="margin-top: 24px;">
                                <strong>Order number:</strong>
                                {{ $order->order_number }}
                            </p>

                            <p>
                                <strong>Payment status:</strong>
                                {{ ucfirst($order->status->value ?? $order->status) }}
                            </p>

                            <h2 style="margin-top: 32px; font-size: 18px;">
                                Order items
                            </h2>

                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0">
                                @foreach ($order->orderItems as $item)
                                    <tr>
                                        <td style="padding: 16px 0; border-bottom: 1px solid #e4e4e7; width: 80px;">
                                            @if ($item->product->primaryImage)
                                                <img
                                                    src="{{ $item->product->primaryImage->image_url }}"
                                                    alt="{{ $item->product_name }}"
                                                    width="64"
                                                    style="display: block; width: 64px; height: 64px; object-fit: contain;"
                                                >
                                            @endif
                                        </td>

                                        <td style="padding: 16px 8px; border-bottom: 1px solid #e4e4e7;">
                                            <strong>{{ $item->product_name }}</strong>
                                            <p style="margin: 8px 0 0; color: #71717a; font-size: 14px;">
                                                Quantity: {{ $item->quantity }}
                                            </p>
                                        </td>

                                        <td align="right" style="padding: 16px 0; border-bottom: 1px solid #e4e4e7; white-space: nowrap;">
                                            ${{ number_format($item->unit_price * $item->quantity, 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </table>

                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0"
                                style="margin-top: 24px;">
                                <tr>
                                    <td style="padding: 8px 0; color: #52525b;">Subtotal</td>
                                    <td align="right">
                                        ${{ number_format($order->subtotal, 2) }}
                                    </td>
                                </tr>

                                <tr>
                                    <td style="padding: 8px 0; color: #52525b;">Delivery</td>
                                    <td align="right">
                                        ${{ number_format($order->delivery, 2) }}
                                    </td>
                                </tr>

                                <tr>
                                    <td style="padding: 16px 0; border-top: 1px solid #e4e4e7; font-size: 18px;">
                                        <strong>Total paid</strong>
                                    </td>
                                    <td align="right" style="padding: 16px 0; border-top: 1px solid #e4e4e7; font-size: 18px;">
                                        <strong>${{ number_format($order->total, 2) }}</strong>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin-top: 32px; color: #71717a; font-size: 13px; line-height: 1.6;">
                                Thank you for shopping with us. If you have any questions
                                about your order, please contact our support team.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

</body>
</html>