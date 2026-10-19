<?php

declare(strict_types=1);

namespace App\Enums;

enum PaymentStatus: string
{
    case Pending = 'pending';
    case Paid = 'paid';
    case Failed = 'failed';
    case Refunded = 'refunded';
    case Cancelled = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'pending',
            self::Paid => 'paid',
            self::Failed => 'failed',
            self::Refunded => 'refunded',
            self::Cancelled => 'cancelled',
        };
    }
}
