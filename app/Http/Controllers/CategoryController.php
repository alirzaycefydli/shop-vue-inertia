<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Categories\AllCategories;
use App\Actions\Categories\CategoriesBySlug;
use App\Actions\Products\AllProducts;
use App\Data\ProductFilterData;
use App\Enums\ProductSort;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductCardResource;
use Illuminate\Http\Request;
use Inertia\Inertia;

final class CategoryController extends Controller
{
    public function index(Request $request, AllCategories $action, AllProducts $allProductsAction, CategoriesBySlug $categoriesBySlug)
    {
        return Inertia::render('Categories/Index', [
            'categories' => CategoryResource::collection($action->handle()),
            'products' => ProductCardResource::collection(
                $allProductsAction->handle(
                    ProductFilterData::fromRequest($request),
                    $request->has('category') && $request->input('category') !== null ?
                        $categoriesBySlug->handle($request->category)->descendantsAndSelfIDs() :
                        null,
                )
            ),
            'sort' => $request->query('sort') ?? ProductSort::Newest,
            'sortOptions' => collect(ProductSort::cases())
                ->map(fn (ProductSort $sort) => [
                    'value' => $sort->value,
                    'label' => $sort->label(),
                ]),
        ]);
    }
}
