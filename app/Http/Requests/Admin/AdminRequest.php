<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
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
            'email' => 'required|email',
            'role_id' => 'nullable|exists:roles,id',
            'phone_number' => 'nullable|string|max:20',
            'status' => 'required|in:active,inactive'
        ];

        if ($this->isMethod('POST')) {
            $rules['password'] = 'required|min:8';
            $rules['email'] .= '|unique:admins,email';
        } else {
            $rules['password'] = 'nullable|min:8';
            $rules['email'] .= '|unique:admins,email,' . $this->route('admin')->id;
        }

        return $rules;
    }
}
