<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBeneficiaryRequest extends FormRequest
{
    const VALIDATION_RULES = [
        'name' => 'required|max:100',
        'img' => 'nullable|max:255',
    ];

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $beneficiary = $this->route()->parameter('beneficiary');
        if ($beneficiary == null)
            return true;

        return $beneficiary->user_id == $this->user()->id;
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
