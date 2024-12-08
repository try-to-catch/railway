<?php

namespace App\Http\Requests\Seat;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreSeatRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'number' => ['required', 'string'],
            'is_reserved' => ['required', 'boolean'],
        ];
    }
}
