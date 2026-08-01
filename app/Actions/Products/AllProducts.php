<?php

declare(strict_types=1);

namespace App\Actions\Products;

use App\Data\ProductFilterData;
use App\Enums\ProductSort;
use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;

final class AllProducts
{
    /**
     * @return LengthAwarePaginator<int, Product>
     */
    public function handle(ProductFilterData $filters): LengthAwarePaginator
    {
        $query = Product::query();

        if ($filters->search) {
            $query->where('name', 'like', "%{$filters->search}%")
                ->orWhere('description', 'like', "%{$filters->search}%");
        }

        if ($filters->sort) {
            match ($filters->sort) {
                ProductSort::Newest => $query->latest(),
                ProductSort::Oldest => $query->oldest(),
                ProductSort::NameAscending => $query->orderBy('name', 'asc'),
                ProductSort::NameDescending => $query->orderBy('name', 'desc'),
                ProductSort::PriceHigh => $query->orderBy('price', 'asc'),
                ProductSort::PriceLow => $query->orderBy('price', 'desc'),
            };
        }

        // TODO:: Filter by categories

        return $query
            ->with(['primaryImage', 'primaryCategory'])
            ->paginate($filters->perPage)
            ->withQueryString();
    }
}
