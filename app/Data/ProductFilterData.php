<?php

declare(strict_types=1);

namespace App\Data;

use App\Enums\ProductSort;
use Illuminate\Http\Request;

final readonly class ProductFilterData
{
    public function __construct(
        public ?string $search = null,
        public ?ProductSort $sort = null,
        public ?string $category = null,
        public ?int $perPage = 2,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            search: $request->input('search'),
            sort: ProductSort::tryFrom($request->input('sort') ?? ProductSort::Newest->value),
            category: $request->input('category'),
        );
    }
}
