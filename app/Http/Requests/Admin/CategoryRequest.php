<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories', 'slug')->ignore($this->route('id'))
            ],
            'description' => ['nullable', 'string', 'max:1000']
        ];

        // Add image validation rule based on whether it's a create or update request
        if ($this->isMethod('POST')) {
            $rules['image'] = ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'];
        } else {
            $rules['image'] = ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'];
        }

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The category name is required.',
            'name.max' => 'The category name cannot exceed 255 characters.',
            'slug.required' => 'The category slug is required.',
            'slug.unique' => 'This slug is already in use.',
            'image.required' => 'Please upload a category image.',
            'image.image' => 'The file must be an image.',
            'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif.',
            'image.max' => 'The image size cannot exceed 2MB.'
        ];
    }
}
