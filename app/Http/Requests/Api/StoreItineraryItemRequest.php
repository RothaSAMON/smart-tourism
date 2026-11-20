<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class StoreItineraryItemRequest extends FormRequest
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
            'attraction_id' => ['required', 'integer', 'exists:table_attractions,id'],
            'day_number' => ['required', 'integer', 'min:1'],
            'visit_order' => ['required', 'integer', 'min:1'],
        ];
    }
}

