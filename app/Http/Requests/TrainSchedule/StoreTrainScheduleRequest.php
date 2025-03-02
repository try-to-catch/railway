<?php

namespace App\Http\Requests\TrainSchedule;

use Illuminate\Foundation\Http\FormRequest;

class StoreTrainScheduleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'departure' => ['required', 'date'],
            'arrival' => ['required', 'date', 'after:departure'],
        ];
    }
}
