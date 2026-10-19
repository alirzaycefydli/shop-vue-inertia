<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\AddressFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['alias', 'user_id', 'name', 'address', 'city', 'postal_code', 'country'])]
final class Address extends Model
{
    /** @use HasFactory<AddressFactory> */
    use HasFactory, HasUuids;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
