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
            'number' => ['required', 'string', 'max:255'],
            'is_reserved' => ['nullable', 'boolean'],
            'price' => ['required', 'numeric', 'min:0'],
            'train_schedule_id' => ['required', 'integer', 'exists:train_schedules,id'],
        ];
    }
}
