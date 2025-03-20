<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoleRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $roleId = $this->route('role'); // Get the role ID from the route parameter if it exists

        return [
            'role_name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('roles', 'role_name')->ignore($roleId)
            ],
            'description' => 'nullable|string|max:255'
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'role_name.required' => 'The role name is required.',
            'role_name.string' => 'The role name must be a string.',
            'role_name.max' => 'The role name cannot exceed 100 characters.',
            'role_name.unique' => 'This role name is already taken.',
            'description.string' => 'The description must be a string.',
            'description.max' => 'The description cannot exceed 255 characters.'
        ];
    }
}