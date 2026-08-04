<?php

declare(strict_types=1);

namespace App\Enums;

enum ProductSort: string
{
    case Newest = 'newest';
    case Oldest = 'oldest';
    case PriceLow = 'price_low';
    case PriceHigh = 'price_high';
    case NameAscending = 'name_ascending';
    case NameDescending = 'name_descending';

    public function label(): string
    {
        return match ($this) {
            self::Newest => 'Newest',
            self::Oldest => 'Oldest',
            self::PriceLow => 'Price: Low to high',
            self::PriceHigh => 'Price: High to low',
            self::NameAscending => 'Name: A to Z',
            self::NameDescending => 'Name: Z to A',
        };
    }
}
