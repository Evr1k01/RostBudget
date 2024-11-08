<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MonthReportResource extends JsonResource {

    public function toArray($request): array {
        return [
            'id' => $this->id,
            'sum' => $this->sum,
            'month' => $this->month,
            'year' => $this->year,
            'category' => $this->top_category
        ];
    }
}
