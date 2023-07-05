<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreChartRequest extends FormRequest
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
            'kind' => 'required|in:line,bar,pie,list',
            'interval' => 'required|in:year,month',
            'stat' => 'required|in:sum,avg,count,min,max',
            # FIXME: allow all only for 'bar' and 'line'
            'filter' => 'required|in:all,categories,beneficiaries,accounts',
            # FIXME: check the id exists in one of 'accounts', 'beneficiaries', 'categories'
            'filter_id' => 'nullable',
            # FIXME
            'filter_type' => 'nullable|in:categories,beneficiaries,accounts',
            'favorite' => 'nullable'
        ];
    }
}
