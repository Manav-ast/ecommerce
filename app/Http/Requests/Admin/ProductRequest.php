<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'categories' => 'array|required',
        ];

        // For create request, image is required
        if ($this->isMethod('post')) {
            $rules['image'] = 'required|image|mimes:jpeg,png,jpg,gif|max:2048';
            $rules['slug'] = 'required|string|max:255|unique:products,slug';
        }

        // For update request, image is optional and slug should ignore current product
        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['image'] = 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048';
            $rules['slug'] = 'required|string|max:255|unique:products,slug,' . $this->route('id');
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
            'name.required' => 'The product name is required.',
            'name.max' => 'The product name cannot exceed 255 characters.',
            'slug.required' => 'The product slug is required.',
            'slug.unique' => 'This slug is already in use.',
            'price.required' => 'The product price is required.',
            'price.numeric' => 'The price must be a number.',
            'price.min' => 'The price cannot be negative.',
            'stock_quantity.required' => 'The stock quantity is required.',
            'stock_quantity.integer' => 'The stock quantity must be a whole number.',
            'stock_quantity.min' => 'The stock quantity cannot be negative.',
            'image.required' => 'Please upload a product image.',
            'image.image' => 'The file must be an image.',
            'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif.',
            'image.max' => 'The image size cannot exceed 2MB.',
            'categories.required' => 'Please select at least one category.',
            'categories.array' => 'Categories must be selected properly.',
        ];
    }
}