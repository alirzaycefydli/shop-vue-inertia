<?php

declare(strict_types=1);

namespace App\Actions\Products;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

final readonly class ProductsByCategory
{
    public function handle(Builder $query, ?Collection $categoryIds): Builder
    {
        if ($categoryIds === null) {
            return $query;
        }

        return $query->whereHas('categories', function ($query) use ($categoryIds) {
            $query->whereIn('categories.id', $categoryIds);
        });
    }
}
