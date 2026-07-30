<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

final class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        /*  User::factory()->create([
              'name' => 'Test User',
              'email' => 'test@example.com',
          ]);*/

        /*        $categories = Category::factory(5)->create();

                Category::factory(5)
                    ->withParent()
                    ->create();

                Product::factory(10)
                    ->withImages(3)
                    ->create()
                    ->each(function (Product $product) use ($categories) {
                        $category = $categories->random();

                        $product->update([
                            'primary_category_id' => $category->id,
                        ]);

                        $product->categories()->sync([
                            $category->id,
                        ]);
                    });*/

        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
        ]);
    }
}
