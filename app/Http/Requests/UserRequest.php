<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest {
    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        $rules = [
            'name' => 'required|string',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8|max:255',
        ];
        $baseRules = [];

        return match($this->getMethod()) {
            'POST' => $rules,
            default => $baseRules,
        };
    }
}
