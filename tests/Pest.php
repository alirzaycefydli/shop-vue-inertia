<?php

declare(strict_types=1);

use App\Actions\Addresses\CreateAddress;
use App\Actions\Orders\CreateOrder;
use App\Actions\Orders\CreateOrderItem;
use App\Actions\Orders\PrepareOrderItems;
use App\Enums\ProductStatus;
use App\Models\Address;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "pest()" function to bind different classes or traits.
|
*/

pest()->extend(TestCase::class)
    ->use(RefreshDatabase::class)
    ->in('Feature');

pest()->extend(TestCase::class)
    ->use(RefreshDatabase::class)
    ->in('Unit');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

function createTestUser(
    ?string $email = 'test@example.com',
    ?string $password = 'password',
    ?bool $remember = null
): User {
    return User::factory()->create([
        'email' => $email,
        'password' => $password,
        'remember_token' => $remember,
    ]);
}

function createAddress(?User $user = null): Address
{
    $action = new CreateAddress;

    return $action->handle([
        'alias' => 'Test Alias',
        'user_id' => $user?->id,
        'name' => 'Test',
        'address' => 'Test Address',
        'city' => 'Test City',
        'postal_code' => '00-000',
        'country' => 'Test Country',
    ]);
}

function createProductCategory(?string $parent_id = null): Category
{
    $attributes = [];

    if ($parent_id !== null) {
        $attributes['parent_id'] = $parent_id;
    }

    return Category::factory()->create($attributes);
}

function createProduct(
    string $productStatus,
    ?int $quantity = null,
    ?float $price = null,
    ?string $primary_category_id = null,
): Product {
    $attributes = [
        'status' => $productStatus,
    ];

    if ($quantity !== null) {
        $attributes['stock_quantity'] = $quantity;
    }
    if ($price !== null) {
        $attributes['price'] = $price;
    }
    if ($primary_category_id !== null) {
        $attributes['primary_category_id'] = $primary_category_id;
    }

    return Product::factory()->create($attributes);
}

function createOrder(array $products = []): Order
{
    $orderItems = new CreateOrderItem;
    $prepareOrderItems = new PrepareOrderItems;

    $order = new CreateOrder($orderItems, $prepareOrderItems);

    return $order->handle(
        prepareOrderItems($products ?: [[]]),
        createAddress()->id,
    );
}

function prepareOrderItems(array $products): array
{
    return array_map(function (array $item) {
        return [
            'product' => createProduct(
                $item['status'] ?? ProductStatus::Active->value,
                $item['stock_quantity'] ?? null,
                $item['price'] ?? null,
            ),
            'quantity' => $item['quantity'] ?? 1,
        ];
    }, $products);
}
