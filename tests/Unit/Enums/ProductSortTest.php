<?php

use App\Enums\ProductSort;

test('product sort has correct values', function () {
    expect(ProductSort::Newest->value)->toBe('newest')
        ->and(ProductSort::NameAscending->value)->toBe('name_ascending');
});

test('product status has all expected cases', function () {
    expect(ProductSort::cases())->toHaveCount(6);
});

test('product status returns correct labels', function () {
    expect(ProductSort::NameDescending->label())->toBe('Name: Z to A')
        ->and(ProductSort::PriceLow->label())->toBe('Price: Low to high');
});
