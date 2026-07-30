<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Products\AllProducts;
use App\Actions\Products\SingleProduct;
use App\Data\ProductFilterData;
use App\Enums\ProductSort;
use App\Http\Resources\ProductCardResource;
use App\Http\Resources\ProductDetailResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

final class ProductController extends Controller
{
    public function index(Request $request, AllProducts $action)
    {
        return Inertia::render('Products/Index', [
            'products' => ProductCardResource::collection(
                $action->handle(
                    ProductFilterData::fromRequest($request)
                )
            ),
            'sortOptions' => collect(ProductSort::cases())
                ->map(fn (ProductSort $sort) => [
                    'value' => $sort->value,
                    'label' => $sort->label(),
                ]),
        ]);
    }

    public function show(Product $product, SingleProduct $action)
    {
        // return ProductDetailResource::make($action->handle($product));
        return Inertia::render('Products/Show', [
            'product' => ProductDetailResource::make($action->handle($product)),
        ]);
    }
}
