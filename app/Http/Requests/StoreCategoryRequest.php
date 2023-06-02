<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    const VALIDATION_RULES = [
        'name' => 'required|max:100',
        'type' => 'required_without:parent_category_id|in:out,in',
        'icon' => 'required|max:255',
        'parent_category_id' => 'nullable|exists:categories,id'
    ];

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
        return self::VALIDATION_RULES;
    }
}
