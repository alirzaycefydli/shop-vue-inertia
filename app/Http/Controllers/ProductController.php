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
use Inertia\Response;

final class ProductController extends Controller
{
    public function index(Request $request, AllProducts $action): Response
    {
        return Inertia::render('Products/Index', [
            'products' => ProductCardResource::collection(
                $action->handle(
                    ProductFilterData::fromRequest($request),
                    null
                )
            ),
            'sortOptions' => collect(ProductSort::cases())
                ->map(fn (ProductSort $sort) => [
                    'value' => $sort->value,
                    'label' => $sort->label(),
                ]),
            'search' => $request->query('search'),
            'sort' => $request->query('sort') ?? ProductSort::Newest,
        ]);
    }

    public function show(Product $product, SingleProduct $action): Response
    {
        return Inertia::render('Products/Show', [
            'product' => ProductDetailResource::make($action->handle($product)),
        ]);
    }
}
