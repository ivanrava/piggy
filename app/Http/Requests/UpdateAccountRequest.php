<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAccountRequest extends FormRequest
{
    const VALIDATION_RULES = [
        'account_type_id' => 'required|exists:account_types,id',
        'name' => 'required|max:50',
        'icon' => 'required|max:200',
        'color' => 'required|max:6|min:6',
        'opening' => 'required|date',
        'closing' => 'nullable|date|after:opening',
        'description' => 'nullable|max:500'
    ];

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return self::VALIDATION_RULES;
    }
}
