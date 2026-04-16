<?php

namespace App\Http\Requests\Api\Public;

use Illuminate\Foundation\Http\FormRequest;

class StoreEnquiryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Public endpoint
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'company_name' => ['nullable', 'string', 'max:255'],
            'project_type_id' => ['required', 'exists:project_types,id'],
            'budget_estimation' => ['nullable', 'string', 'max:100'],
            'estimated_timeline' => ['nullable', 'string', 'max:100'],
            'requirements' => ['required', 'string'],
        ];
    }
}