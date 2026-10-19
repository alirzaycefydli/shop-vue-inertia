<?php

declare(strict_types=1);

namespace App\Actions\Addresses;

use App\Models\Address;

final class CreateAddress
{
    public function handle(array $data): Address
    {
        return Address::create([
            'alias' => $data['alias'] ?? null,
            'user_id' => auth()->id(),
            'name' => $data['name'],
            'address' => $data['address'],
            'city' => $data['city'],
            'postal_code' => $data['postal_code'],
            'country' => $data['country'],
        ]);
    }
}
