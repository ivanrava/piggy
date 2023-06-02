<?php

namespace App\Http\Requests;

use App\Models\Beneficiary;
use App\Models\Category;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTransactionRequest extends FormRequest
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
        return array_merge(
            [
                'account_id' => 'required|exists:accounts,id',
                'beneficiary' => 'required',
                'beneficiary.id' => 'required',
                'category' => 'required',
                'category.id' => 'required',
                'date' => 'required|date',
                'amount' => 'required|decimal:0,2|between:0.01,99999999.99',
                'notes' => 'nullable|max:500'
            ],
            $this->make_nested_rules_for(StoreBeneficiaryRequest::VALIDATION_RULES, 'beneficiary'),
            $this->make_nested_rules_for(StoreCategoryRequest::VALIDATION_RULES, 'category')
        );
    }

    protected function make_nested_rules_for(array $rules, string $with_prefix): array
    {
        return array_combine(
            array_map(fn ($attribute) =>  "$with_prefix.$attribute", array_keys($rules)),
            $rules
        );
    }

    public function beneficiary()
    {
        return Beneficiary::findOr($this->beneficiary['id'], function () {
            $b = new Beneficiary();
            $b->user_id = $this->user()->id;
            $b->name = $this->beneficiary['name'];
            $b->img = $this->beneficiary['img'];
            return $b;
        });
    }

    public function category()
    {
        return Category::findOr($this->category['id'], function () {
            $c = new Category();
            $c->user_id = $this->user()->id;
            $c->name = $this->category['name'];
            $c->icon = $this->category['icon'];
            $c->parent_category_id = $this->category['parent_category_id'];
            $c->type = $this->category['type'];
            return $c;
        });
    }
}
