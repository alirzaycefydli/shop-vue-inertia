<?php

declare(strict_types=1);

namespace App\Actions\Products;

use App\Enums\ProductSort;
use Illuminate\Database\Eloquent\Builder;

final readonly class ProductSorting
{
    public function handle(Builder $query, ?ProductSort $sort): Builder
    {
        match ($sort) {
            ProductSort::Newest => $query->latest(),
            ProductSort::Oldest => $query->oldest(),
            ProductSort::NameAscending => $query->orderBy('name', 'asc'),
            ProductSort::NameDescending => $query->orderBy('name', 'desc'),
            ProductSort::PriceHigh => $query->orderBy('price', 'desc'),
            ProductSort::PriceLow => $query->orderBy('price', 'asc'),
            default => ProductSort::Newest,
        };

        return $query;
    }
}
