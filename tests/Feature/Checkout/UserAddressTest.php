<?php

declare(strict_types=1);

use App\Actions\Addresses\CreateAddress;
use App\Actions\Addresses\ResolveCheckoutAddress;

test('guest user`s address correctly saved', function () {
    $address = createAddress();

    $this->assertDatabaseCount('addresses', 1)
        ->assertDatabaseHas('addresses', [
            'alias' => $address->alias,
            'user_id' => null,
            'name' => $address->name,
            'address' => $address->address,
            'city' => $address->city,
            'postal_code' => $address->postal_code,
            'country' => $address->country,
        ]);
});

test('authenticated user`s address correctly saved', function () {
    $user = createTestUser();

    $this->actingAs($user);
    $address = createAddress();

    $this->assertDatabaseCount('addresses', 1)
        ->assertDatabaseHas('addresses', [
            'alias' => $address->alias,
            'user_id' => $user->id,
            'name' => $address->name,
            'address' => $address->address,
            'city' => $address->city,
            'postal_code' => $address->postal_code,
            'country' => $address->country,
        ]);
});

test('authenticated user`s saved address correctly retrieved', function () {
    $user = createTestUser();
    $this->actingAs($user);
    $addressAction = new CreateAddress;
    $address = $addressAction->handle([
        'alias' => 'Test Alias',
        'user_id' => $user->id,
        'name' => 'Test',
        'address' => 'Test Address',
        'city' => 'Test City',
        'postal_code' => '00-000',
        'country' => 'Test Country',
    ]);

    $resolveAddress = new ResolveCheckoutAddress($addressAction);
    $data = $resolveAddress->handle([
        'type' => 'saved',
        'id' => $address->id,
    ]);

    $this->assertDatabaseCount('addresses', 1)
        ->assertDatabaseHas('addresses', [
            'alias' => $data->alias,
            'user_id' => $data->user_id,
            'name' => $data->name,
            'address' => $data->address,
            'city' => $data->city,
            'postal_code' => $data->postal_code,
            'country' => $data->country,
        ]);
});
