<?php

declare(strict_types=1);

namespace App\Actions\Products;

use App\Data\ProductFilterData;
use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

final readonly class AllProducts
{
    public function __construct(private ProductSorting $sorting, private ProductsByCategory $productsByCategory) {}

    /**
     * @return LengthAwarePaginator<int, Product>
     */
    public function handle(ProductFilterData $filters, ?Collection $categoryIDs): LengthAwarePaginator
    {
        $query = Product::query();

        if ($filters->search) {
            $query->where(function ($query) use ($filters) {
                $query->where('name', 'like', "%{$filters->search}%")
                    ->orWhere('description', 'like', "%{$filters->search}%");
            });
        }

        if ($filters->sort) {
            $this->sorting->handle($query, $filters->sort);
        }

        $this->productsByCategory->handle($query, $categoryIDs);

        return $query
            ->with(['primaryImage', 'primaryCategory'])
            ->paginate($filters->perPage)
            ->withQueryString();
    }
}
