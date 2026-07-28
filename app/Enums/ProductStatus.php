<?php

declare(strict_types=1);

namespace App\Enums;

enum ProductStatus: string
{
    case Draft = 'draft'; // Product is being created but not visible to customers
    case Active = 'active'; // Product appears in the shop and can be purchased
    case Inactive = 'inactive'; // Product exists but is hidden (discontinued, temporarily unavailable, etc.)

    public function label(): string
    {
        return match ($this) {
            self::Draft => 'Draft',
            self::Active => 'Active',
            self::Inactive => 'Inactive',
        };
    }
}
