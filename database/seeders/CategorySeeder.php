<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

final class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = require database_path('seeders/Data/catalog.php');

        foreach ($categories['categories'] as $category) {
            $this->createCategory($category);
        }
    }

    private function createCategory(array $data, ?Category $parent = null): Category
    {
        $category = Category::create([
            'name' => $data['name'],
            'slug' => $data['slug'],
            'parent_id' => $parent?->id,
        ]);

        foreach ($data['children'] ?? [] as $child) {
            $this->createCategory($child, $category);
        }

        return $category;
    }
}
