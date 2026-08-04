<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\CategoryFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

#[Fillable(['name', 'slug', 'parent_id'])]
final class Category extends Model
{
    /** @use HasFactory<CategoryFactory> */
    use HasFactory, HasUuids;

    /**
     * @return BelongsToMany<Product, $this>
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'category_product', 'category_id', 'product_id');
    }

    /**
     * @return BelongsTo<Category, $this>
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * @return HasMany<Category, $this>
     */
    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /**
     * @return BelongsTo<Category, $this>
     */
    public function parentRecursive(): BelongsTo
    {
        return $this->parent()->with('parentRecursive');
    }

    /**
     * @return HasMany<Category, $this>
     */
    public function childrenRecursive(): HasMany
    {
        return $this->children()->with('childrenRecursive');
    }

    /**
     * Returns the IDs of parent and it's recursive children
     *
     * @return Collection<int, string>
     */
    public function descendantsAndSelfIDs(): Collection
    {
        // Does the exact same.
        /*return collect([$this])
            ->flatMap(fn () => [
                $this->id,
                ...$this->childrenRecursive->pluck('id'),
            ]);*/

        // Does the exact same.
        /*return collect([$this->id])
            ->merge(
                $this->childrenRecursive->pluck('id')
            );*/

        return collect([
            $this->id,
            ...$this->childrenRecursive->pluck('id'),
        ]);
    }

    /**
     * Returning a reversed array that contains the tree of parent-child recursive category list
     *
     * return array
     */
    public function breadcrumbs(): array
    {
        $categories = collect();

        $category = $this;

        while ($category) {
            $categories->prepend([
                'name' => $category->name,
                'slug' => $category->slug,
            ]);

            $category = $category->parent;
        }

        return $categories->values()->all();
    }
}
