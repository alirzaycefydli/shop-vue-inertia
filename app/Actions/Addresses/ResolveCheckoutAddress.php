<?php

declare(strict_types=1);

namespace App\Actions\Addresses;

use App\Models\Address;

final class ResolveCheckoutAddress
{
    public function __construct(
        private CreateAddress $createAddress,
    ) {}

    public function handle(array $data): Address
    {
        if ($data['type'] === 'saved') {
            return Address::query()
                ->whereKey($data['id'])
                ->where('user_id', auth()->id())
                ->firstOrFail();
        }

        return $this->createAddress->handle($data);
    }
}
