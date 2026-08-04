<?php

declare(strict_types=1);

namespace App\Actions\Categories;

use App\Models\Category;

final readonly class AllCategories
{
    public function handle()
    {
        return Category::whereNull('parent_id')
            ->with('childrenRecursive')
            ->get();
    }
}
