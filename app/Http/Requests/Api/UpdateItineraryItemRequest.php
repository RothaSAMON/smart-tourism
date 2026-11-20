<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class UpdateItineraryItemRequest extends FormRequest
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
            'attraction_id' => ['sometimes', 'required', 'integer', 'exists:table_attractions,id'],
            'day_number' => ['sometimes', 'required', 'integer', 'min:1'],
            'visit_order' => ['sometimes', 'required', 'integer', 'min:1'],
        ];
    }
}

