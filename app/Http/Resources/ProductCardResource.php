<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductCardResource extends JsonResource
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
            'image' => $this->whenLoaded('primaryImage', function () {
                return $this->primaryImage->image_url;
            }),
            'category' => $this->whenLoaded('primaryCategory', function () {
                return $this->primaryCategory->name;
            })
        ];
    }
}
