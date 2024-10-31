<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequest extends FormRequest {
    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        $rules = [
            'description' => 'required|string',
            'expense' => 'required|numeric',
            'date' => 'required|date',
            'categoryId' => 'required|uuid|exists:categories,id',
        ];

        $getRules = [];

        return match ($this->getMethod()) {
            'POST' => $rules,
            'PUT' => $rules + ['id' => 'required|uuid|exists:purchases,id'],
            default => $getRules,
        };
    }
}
