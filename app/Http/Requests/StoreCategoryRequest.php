<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
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
        return [
            'name' => 'required|max:100',
            'type' => 'required_without:parent_category_id|in:out,in',
            'icon' => 'required|max:255',
            'parent_category_id' => 'nullable|exists:categories,id',
            'budget_overall' => 'nullable|decimal:0,2|between:0,99999999.99',
            'budget' => 'required_without:budget_overall|exclude_unless:parent_category_id,!=,null|array:jan,feb,mar,apr,may,jun,jul,aug,sep,oct,nov,dec',
            'budget.*' => 'required|exclude_unless:parent_category_id,!=,null|decimal:0,2|between:0,99999999.99'
        ];
    }

    public function messages(): array
    {
        return [
            'budget_overall' => 'Less than 1 billion',
            'budget.*' => 'Less than 1 billion'
        ];
    }
}
