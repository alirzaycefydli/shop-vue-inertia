<?php

declare(strict_types=1);

namespace App\Actions\Products;

use App\Data\ProductFilterData;
use App\Enums\ProductSort;
use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;

final class AllProducts
{
    public function handle(ProductFilterData $filters): LengthAwarePaginator
    {
        $query = Product::query();

        // TODO:: Implement search functionality
        if ($filters->search) {
            $query->where('name', 'like', "%{$filters->search}%");
        }

        if ($filters->sort) {
            match ($filters->sort) {
                ProductSort::Newest => $query->latest(),
                ProductSort::Oldest => $query->oldest(),
                ProductSort::NameAscending => $query->orderBy('name', 'ASC'),
                ProductSort::NameDescending => $query->orderBy('name', 'DESC'),
                ProductSort::PriceHigh => $query->orderBy('price', 'DESC'),
                ProductSort::PriceLow => $query->orderBy('price', 'ASC'),
            };
        }

        // TODO:: Filter by categories

        return $query
            ->with(['primaryImage', 'primaryCategory'])
            ->paginate($filters->perPage)
            ->withQueryString();
    }
}
