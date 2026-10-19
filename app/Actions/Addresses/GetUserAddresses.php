<?php

declare(strict_types=1);

namespace App\Actions\Addresses;

use App\Models\Address;
use Illuminate\Support\Collection;

final class GetUserAddresses
{
    public function handle(): Collection
    {
        return Address::whereNotNull('alias')
            ->where('user_id', auth()->user()->id)
            ->get();
    }
}
