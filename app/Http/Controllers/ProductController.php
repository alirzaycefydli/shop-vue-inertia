<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Products\SingleProduct;
use App\Http\Resources\ProductDetailResource;
use App\Models\Product;
use Inertia\Inertia;

final class ProductController extends Controller
{
    public function show(Product $product, SingleProduct $action)
    {
        //return ProductDetailResource::make($action->handle($product));
        return Inertia::render('Products/Show', [
            'product' => ProductDetailResource::make($action->handle($product)),
        ]);
    }
}
