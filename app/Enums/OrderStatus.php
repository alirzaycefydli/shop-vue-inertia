<?php

declare(strict_types=1);

namespace App\Enums;

enum OrderStatus: string
{
    case Pending = 'pending';
    case Paid = 'paid';
    case Processing = 'processing';
    case Shipped = 'shipped';
    case Completed = 'completed';
    case Cancelled = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'pending',
            self::Paid => 'paid',
            self::Processing => 'processing',
            self::Shipped => 'shipped',
            self::Completed => 'completed',
            self::Cancelled => 'cancelled',
        };
    }
}
