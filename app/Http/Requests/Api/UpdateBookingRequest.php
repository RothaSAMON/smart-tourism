<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'user_id' => ['sometimes', 'required', 'integer', 'exists:users,id'],
            'business_id' => ['sometimes', 'required', 'integer', 'exists:table_businesses,id'],
            'booking_date' => ['sometimes', 'required', 'date', 'date_format:Y-m-d'],
            'people' => ['sometimes', 'required', 'integer', 'min:1'],
            'total_price' => ['sometimes', 'required', 'numeric', 'min:0'],
            'status' => ['sometimes', 'required', Rule::in(['pending', 'confirmed', 'cancelled'])],
        ];
    }
}

