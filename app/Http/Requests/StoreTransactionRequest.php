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
        $transaction = $this->route()->parameter('transaction');
        if ($transaction == null)
            return true;

        return $transaction->beneficiary->user_id == $this->user()->id;
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
                'beneficiary.name' => 'exclude_unless:beneficiary.id,<,0|max:100',
                'beneficiary.img' => 'exclude_unless:beneficiary.id,<,0|max:255',
                'category' => 'required',
                'category.id' => 'required',
                'category.name' => 'exclude_unless:category.id,<,0|max:100',
                'category.icon' => 'exclude_unless:category.id,<,0|max:255',
                'category.parent_category_id' => 'exclude_unless:category.id,<,0|exists:categories,id',
                'date' => 'required|date',
                'amount' => 'required|decimal:0,2|between:0.01,99999999.99',
                'notes' => 'nullable|max:500'
            ],
        );
    }

    public function messages(): array
    {
        return [
            'amount.between' => 'Only positive amounts (less than 1 billion)'
        ];
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
            $c->type = Category::find($this->category['parent_category_id'])->type;
            return $c;
        });
    }
}
