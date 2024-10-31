<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CurrencyRequest extends FormRequest {
    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        $rules = [
            'currencyId' => 'required|uuid|exists:currencies,id',
        ];
        $baseRules = [];

        return match($this->getMethod()) {
            'POST' => $rules,
            default => $baseRules,
        };
    }
}
