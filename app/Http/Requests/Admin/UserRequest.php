<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'name' => 'required|string|max:100',
            'email' => 'required|string|email|max:100',
            'phone_no' => 'required|string|size:10',
            'status' => 'required|in:active,inactive',
        ];

        // Add unique validation for store (create) requests
        if ($this->isMethod('post')) {
            $rules['email'] .= '|unique:users';
            $rules['phone_no'] .= '|unique:users';
            $rules['password'] = 'required|string|min:6|confirmed';
        }

        // Add unique validation for update requests, excluding the current user
        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $userId = $this->route('id');
            $rules['email'] .= '|unique:users,email,' . $userId;
            $rules['phone_no'] .= '|unique:users,phone_no,' . $userId;
            $rules['password'] = 'nullable|string|min:6|confirmed';
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
            'name.required' => 'The name field is required.',
            'name.max' => 'The name must not exceed 100 characters.',
            'email.required' => 'The email field is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already registered.',
            'phone_no.required' => 'The phone number field is required.',
            'phone_no.size' => 'The phone number must be exactly 10 digits.',
            'phone_no.unique' => 'This phone number is already registered.',
            'password.required' => 'The password field is required for new users.',
            'password.min' => 'The password must be at least 6 characters.',
            'password.confirmed' => 'The password confirmation does not match.',
            'status.required' => 'The status field is required.',
            'status.in' => 'The status must be either active or inactive.',
        ];
    }
}