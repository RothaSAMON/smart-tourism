<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class StoreAttractionRequest extends FormRequest
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
            'province_id' => ['required', 'integer', 'exists:provinces,id'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
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
