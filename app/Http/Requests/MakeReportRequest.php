<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MakeReportRequest extends FormRequest
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
            'from' => 'nullable|date',
            'to' => 'nullable|date|after:from',
            'sort' => 'nullable|in:date,amount',
            'direction' => 'nullable|in:desc,asc'
        ];
    }

    protected function prepareForValidation()
    {
        $this->mergeIfMissing([
            'sort' => 'date',
            'direction' => 'asc'
        ]);
    }
}
