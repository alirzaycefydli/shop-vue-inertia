<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;
use RuntimeException;

final class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $catalog = require database_path('seeders/Data/catalog.php');

        foreach ($catalog['products'] as $data) {
            $productCategories = Category::whereIn(
                'slug',
                $data['categories']
            )->get();

            $primaryCategory = $productCategories
                ->sortByDesc(fn(Category $category) => $this->categoryDepth($category))
                ->first();

            $product = Product::create([
                'name' => $data['name'],
                'slug' => $data['slug'],
                'description' => $data['description'],
                'detailed_description' => $data['detailed_description'],
                'price' => $data['price'],
                'stock_quantity' => $data['stock_quantity'],
                'status' => $data['status'],
                'primary_category_id' => $primaryCategory->id,
            ]);

            $product->categories()->attach(
                $productCategories
            );

            foreach ($data['images'] as $image) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_url' => $image['image_url'],
                    'position' => $image['position'],
                ]);
            }
        }
    }

    private function categoryDepth(Category $category): int
    {
        $depth = 0;

        while ($category->parent_id) {
            $depth++;
            $category = $category->parent;
        }

        return $depth;
    }
}
