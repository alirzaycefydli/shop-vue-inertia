<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\ProductStatus;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
final class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'slug' => fake()->slug(),
            'description' => fake()->text(),
            'price' => fake()->randomFloat(2, 10, 1000),
            'stock_quantity' => fake()->numberBetween(0, 100),
            'status' => fake()->randomElement(ProductStatus::cases()),
            'primary_category_id' => Category::factory(),
            'detailed_description' => fake()->paragraphs(5, true),
        ];
    }

    /**
     * Define the model's image state.'
     *
     * return ProductFactory|Factory
     */
    public function withImages(int $count = 3): ProductFactory|Factory
    {
        return $this->afterCreating(function (Product $product) use ($count) {
            ProductImage::factory()
                ->count($count)
                ->sequence(fn ($sequence) => [
                    'position' => $sequence->index,
                ])
                ->create([
                    'product_id' => $product->id,
                ]);
        });
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Product $product) {
            $product->categories()->attach(
                $product->primary_category_id
            );
        });
    }
}
