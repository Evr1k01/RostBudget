<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseResource extends JsonResource {

    public function toArray($request): array {
        return [
            'id' => $this->id,
            'description' => $this->description,
            'expense' => $this->expense,
            'date' => $this->date,
            'categoryId' => $this->category_id
        ];
    }
}
