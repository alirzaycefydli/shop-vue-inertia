<?php

declare(strict_types=1);

namespace App\Actions\Categories;

use App\Models\Category;
use Illuminate\Support\Collection;

final readonly class NavigationCategories
{
    public function handle(int $limit = 6): Collection
    {
        return Category::whereNull('parent_id')->limit($limit)->get();
    }
}
