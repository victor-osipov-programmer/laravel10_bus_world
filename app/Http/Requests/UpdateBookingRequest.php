<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


enum PlaceType: string
{
    case from = 'from';
    case back = 'back';
}

class UpdateBookingRequest extends FormRequest
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
            'passenger' => ['required', 'integer', Rule::exists('users', 'id')],
            'seat' => ['required', 'string'],
            'type' => ['required', Rule::enum(PlaceType::class)],
        ];
    }
}
