<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'slug' => $this->slug,
            'price' => $this->price,
            'images' => $this->whenLoaded('images', function ($images) {
                return $images->map(function ($image) {
                    return $image->image_url;
                });
            }),
            'primary_category' => new CategoryResource(
                $this->whenLoaded('primaryCategory')
            ),
            'category_breadcrumbs' => $this->whenLoaded(
                'categories',
                fn() => $this->categories->first()?->breadcrumbs()
            ),
            'description' => $this->description,
            'stock_quantity' => $this->stock_quantity,
            'detailed_description' => $this->detailed_description,
        ];
    }
}
