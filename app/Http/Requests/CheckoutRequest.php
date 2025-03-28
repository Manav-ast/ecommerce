<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
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
        // Always required fields
        $rules = [
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'company' => 'nullable|string|max:100',
            'region' => 'required|string|max:100',
            'address' => 'required|string|max:255',
            'address_line2' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            'postal' => 'required|string|max:20',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:100',
            'payment_method' => 'required|in:credit_card,paypal',
            'address_type' => 'nullable|in:billing,shipping',
            'shipping_same_as_billing' => 'nullable',
            'save_as_default' => 'nullable',
            'agreement' => 'required|accepted'
        ];

        // Add shipping address validation rules if shipping_same_as_billing is empty
        if (empty($this->shipping_same_as_billing)) {
            $rules['shipping_address'] = 'required|string|max:255';
            $rules['shipping_address_line2'] = 'nullable|string|max:255';
            $rules['shipping_city'] = 'required|string|max:100';
            $rules['shipping_state'] = 'nullable|string|max:100';
            $rules['shipping_postal'] = 'required|string|max:20';
            $rules['shipping_region'] = 'required|string|max:100';
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
            'first_name.required' => 'First name is required',
            'last_name.required' => 'Last name is required',
            'region.required' => 'Country/Region is required',
            'address.required' => 'Street address is required',
            'city.required' => 'City is required',
            'postal.required' => 'Postal code is required',
            'phone.required' => 'Phone number is required',
            'email.required' => 'Email address is required',
            'email.email' => 'Please enter a valid email address',
            'payment_method.required' => 'Please select a payment method',
            'address_type.required' => 'Please select an address type',
            'agreement.accepted' => 'You must agree to the Terms and Conditions'
        ];
    }
}
