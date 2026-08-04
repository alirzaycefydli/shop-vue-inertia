<?php

declare(strict_types=1);

namespace App\Actions\Products;

use App\Models\Product;

final readonly class SingleProduct
{
    public function handle(Product $product): Product
    {
        return $product->load([
            'primaryCategory',
            'categories.parentRecursive',
            'images',
        ]);
    }
}
