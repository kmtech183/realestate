<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInquiryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Publicly accessible to all prospective buyers
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|min:2|max:100',
            'email' => 'required|email|max:150',
            'phone' => ['required', 'string', 'regex:/^(\+?[0-9\s\-\(\)]{8,20})$/'],
            'message' => 'required|string|min:10|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'phone.regex' => 'Please provide a valid Indian mobile number (e.g. +91 9876543210).',
            'email.email' => 'Please provide a verified email address.',
        ];
    }
}
