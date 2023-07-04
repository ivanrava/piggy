<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransferRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $transfer = $this->route()->parameter('transfer');
        if ($transfer == null)
            return true;

        return $transfer->user_id == $this->user()->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'from_account_id' => 'required|exists:accounts,id',
            'to_account_id' => 'required|exists:accounts,id',
            'date' => 'required|date',
            'amount' => 'required|decimal:0,2|between:0.01,99999999.99',
            'notes' => 'nullable|max:500'
        ];
    }

    public function messages(): array
    {
        return [
            'amount.between' => 'Only positive amounts (less than 1 billion)',
            'from_account_id.required' => 'Select an account',
            'to_account_id.required' => 'Select an account',
        ];
    }
}
