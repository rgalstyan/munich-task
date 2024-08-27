<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\JsonResource;

final class ProductResource extends JsonResource
{

    public function toArray($request): array
    {
        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'description' => $this->description,
            'price'       => $this->price,
            'sku'         => $this->sku,
            'category' => [
                'id'          => $this->category->id,
                'title'       => $this->category->title,
                'description' => $this->category->description
            ],
        ];
    }
}
