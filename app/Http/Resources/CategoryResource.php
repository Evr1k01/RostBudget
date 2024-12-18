<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource {
    public function toArray($request): array {
        return [
            'id' => $this->id,
            'categoryName' => $this->category_name
        ];
    }
}
