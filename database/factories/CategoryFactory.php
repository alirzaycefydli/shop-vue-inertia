<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Category>
 */
final class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->words(2, true),
            'slug' => fake()->slug(),
            'parent_id' => null,
        ];
    }

    /**
     * Define the model's children state.
     *
     * @return CategoryFactory|Factory
     */
    public function withParent(): CategoryFactory|Factory
    {
        return $this->state(function () {
            return [
                'parent_id' => Category::factory(),
            ];
        });
    }
}
