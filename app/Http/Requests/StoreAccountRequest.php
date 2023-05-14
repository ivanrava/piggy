<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreAccountRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return array_merge(UpdateAccountRequest::VALIDATION_RULES, [
            'initial_balance' => 'required|decimal:0,2|between:0,99999999.99',
        ]);
    }

    public function color(): string
    {
        return substr($this->color, 1);
    }
}
