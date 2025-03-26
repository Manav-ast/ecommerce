<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PageBlockRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'content' => 'required',
            'status' => 'required|in:active,inactive'
        ];

        // Add unique validation for slug on create
        if ($this->isMethod('post')) {
            $rules['slug'] .= '|unique:page_block,slug';
        }
        // Add unique validation for slug on update, excluding current record
        else if ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['slug'] .= '|unique:page_block,slug,' . $this->route('id');
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'title.required' => 'The title field is required.',
            'title.max' => 'The title may not be greater than 255 characters.',
            'slug.required' => 'The slug field is required.',
            'slug.unique' => 'This slug has already been taken.',
            'slug.max' => 'The slug may not be greater than 255 characters.',
            'content.required' => 'The content field is required.',
            'status.required' => 'The status field is required.',
            'status.in' => 'The selected status is invalid.'
        ];
    }
}
