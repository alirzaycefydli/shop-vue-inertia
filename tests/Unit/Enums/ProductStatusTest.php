<?php

declare(strict_types=1);

use App\Enums\ProductStatus;

test('product status has correct values', function () {
    expect(ProductStatus::Active->value)->toBe('active')
        ->and(ProductStatus::Inactive->value)->toBe('inactive');
});

test('product status has all expected cases', function () {
    expect(ProductStatus::cases())->toHaveCount(3);
});

test('product status returns correct labels', function () {
    expect(ProductStatus::Active->label())->toBe('Active')
        ->and(ProductStatus::Inactive->label())->toBe('Inactive');
});
