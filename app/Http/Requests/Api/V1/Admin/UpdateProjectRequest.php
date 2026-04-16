<?php

namespace App\Http\Requests\Api\V1\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class UpdateProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; 
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('title')) {
            $this->merge(['slug' => Str::slug($this->title)]);
        }
    }

    public function rules(): array
    {
        return [
            'client_id' => ['nullable', 'exists:clients,id'],
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            // Ignore the current project ID when checking slug uniqueness
            'slug' => ['sometimes', 'required', 'string', 'unique:projects,slug,' . $this->route('project')->id],
            'description' => ['nullable', 'string'],
            'thumbnail' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'status' => ['sometimes', 'required', 'in:ongoing,completed,archived'],
        ];
    }
}