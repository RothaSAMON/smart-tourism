<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class UpdateItineraryRequest extends FormRequest
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
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'total_days' => ['sometimes', 'required', 'integer', 'min:1'],
            'budget' => ['sometimes', 'numeric', 'min:0'],
            'items' => ['sometimes', 'array'],
            'items.*.attraction_id' => ['required', 'integer', 'exists:table_attractions,id'],
            'items.*.day_number' => ['required', 'integer', 'min:1'],
            'items.*.visit_order' => ['required', 'integer', 'min:1'],
        ];
    }
}

