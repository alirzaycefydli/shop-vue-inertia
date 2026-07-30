<?php

declare(strict_types=1);

namespace App\Actions\Home;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

final class LatestProducts
{

    /**
     * Handle the given product query and return the latest records.
     *
     * @return Collection Collection of the latest product records.
     */
    public function handle(): Collection
    {
        return Product::query()
            ->latest()
            ->with(['primaryImage', 'primaryCategory'])
            ->take(8)
            ->get();
    }
}
