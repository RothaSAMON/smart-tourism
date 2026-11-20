<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAttractionRequest extends FormRequest
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
            'province_id' => ['sometimes', 'required', 'integer', 'exists:table_provinces,id'],
            'category_id' => ['sometimes', 'required', 'integer', 'exists:table_categories,id'],
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'address' => ['nullable', 'string', 'max:255'],
            'opening_hour' => ['nullable', 'date_format:H:i,H:i:s'],
            'closing_hour' => ['nullable', 'date_format:H:i,H:i:s'],
            'entrance_fee' => ['sometimes', 'numeric', 'min:0'],
            'average_rating' => ['sometimes', 'numeric', 'between:0,5'],
            'image' => ['nullable', 'image', 'max:4096'],
        ];
    }
}
