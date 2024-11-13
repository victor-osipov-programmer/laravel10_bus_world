<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'trip_from' => ['required', 'array'],
            'trip_from.id' => ['required', 'integer'],
            'trip_from.date' => ['required', 'date_format:Y-m-d'],

            'trip_back' => ['required', 'array'],
            'trip_back.id' => ['required', 'integer'],
            'trip_back.date' => ['required', 'date_format:Y-m-d'],

            'passengers' => ['required', 'array'],
            'passengers.*.first_name' => ['required', 'string'],
            'passengers.*.last_name' => ['required', 'string'],
            'passengers.*.birth_date' => ['required', 'date_format:Y-m-d'],
            'passengers.*.document_number' => ['required', 'digits:10'],
        ];
    }
}
