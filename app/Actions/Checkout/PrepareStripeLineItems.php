<?php

declare(strict_types=1);

namespace App\Actions\Checkout;

use App\Models\Product;

final class PrepareStripeLineItems
{
    public function handle(array $items): array
    {
        return array_map(function (array $item) {
            /** @var Product $product */
            $product = $item['product'];

            $image = $product->primaryImage()
                ->value('image_url');

            return [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $product->name,
                        'images' => $image ? [$image] : [],
                    ],
                    'unit_amount' => (int) round($product->price * 100),
                ],
                'quantity' => $item['quantity'],
            ];
        }, $items);
    }
}
