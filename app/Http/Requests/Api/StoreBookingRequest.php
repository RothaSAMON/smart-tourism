<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
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
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'business_id' => ['required', 'integer', 'exists:businesses,id'],
            'booking_date' => ['required', 'date', 'date_format:Y-m-d'],
            'people' => ['required', 'integer', 'min:1'],
            'total_price' => ['required', 'numeric', 'min:0'],
        ];
    }
}
