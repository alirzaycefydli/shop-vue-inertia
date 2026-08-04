<?php

declare(strict_types=1);

namespace App\Actions\Categories;

use App\Models\Category;

final readonly class CategoriesBySlug
{
    public function handle(string $slug)
    {
        return Category::where('slug', $slug)
            ->first()
            ->load('childrenRecursive');
    }
}
