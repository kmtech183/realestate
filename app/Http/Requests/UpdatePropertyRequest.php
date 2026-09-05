<?php

namespace App\Http\Requests;

use App\Models\Property;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePropertyRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var Property $property */
        $property = $this->route('property');
        return $this->user()?->can('update', $property) ?? false;
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('price')) {
            $this->merge([
                'price' => preg_replace('/[^0-9.]/', '', (string) $this->price),
            ]);
        }
    }

    public function rules(): array
    {
        /** @var Property $property */
        $property = $this->route('property');

        return [
            'title' => 'required|string|max:255',
            'slug' => ['required', 'string', 'alpha_dash', Rule::unique('properties', 'slug')->ignore($property?->id)],
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
            'status' => 'required|in:active,pending,sold,rented',
            'features' => 'nullable|array',
            'features.*' => 'exists:features,id',
            'images' => 'nullable|array|max:10',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:5120',
        ];
    }
}
