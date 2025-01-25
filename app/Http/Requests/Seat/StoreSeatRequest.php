<?php

namespace App\Http\Requests\Seat;

use Illuminate\Foundation\Http\FormRequest;

class StoreSeatRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'number' => ['required', 'string'],
            'price' => ['required', 'integer'],
            'is_reserved' => ['required', 'boolean'],
            'reserved_by_id' => ['nullable', 'integer'],
        ];
    }
}
