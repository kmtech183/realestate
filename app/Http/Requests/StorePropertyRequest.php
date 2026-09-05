<?php

namespace App\Http\Requests;

use App\Models\Property;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class StorePropertyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->can('create', Property::class) ?? false;
    }

    /**
     * Sanitize inputs before validation.
     */
    protected function prepareForValidation(): void
    {
        if ($this->has('price')) {
            $this->merge([
                'price' => preg_replace('/[^0-9.]/', '', (string) $this->price),
            ]);
        }

        if ($this->has('title') && empty($this->slug)) {
            $this->merge([
                'slug' => Str::slug($this->title) . '-' . rand(1000, 9999),
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'slug' => 'required|string|alpha_dash|unique:properties,slug',
            'category_id' => 'required|exists:property_categories,id',
            'description' => 'required|string|min:20|max:10000',
            'price' => 'required|numeric|min:1000|max:999999999',
            'area_sqft' => 'required|numeric|min:50|max:50000',
            'bedrooms' => 'required|integer|min:0|max:20',
            'bathrooms' => 'required|integer|min:0|max:20',
            'balconies' => 'required|integer|min:0|max:10',
            'address' => 'required|string|max:255',
            'locality' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'pincode' => 'required|string|size:6|regex:/^[0-9]{6}$/',
            'property_type' => 'required|in:sale,rent',
            'features' => 'nullable|array',
            'features.*' => 'exists:features,id',
            'images' => 'nullable|array|max:10',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:5120', // Max 5MB per image
        ];
    }

    /**
     * Custom error messages.
     */
    public function messages(): array
    {
        return [
            'pincode.regex' => 'The pincode must be a valid 6-digit Indian postal code (e.g. 380015).',
            'images.max' => 'You cannot upload more than 10 photos per property.',
            'images.*.max' => 'Each image must not exceed 5MB in size.',
        ];
    }
}
