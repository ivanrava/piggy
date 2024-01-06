<?php

namespace App\Http\Controllers;

use App\Http\Requests\MakeReportRequest;
use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class ReportController extends Controller
{
    public function categories(MakeReportRequest $request): array
    {
        $in = $request->user()
            ->categories()
            ->with('children.budget')
            ->where('type', 'in')
            ->withSum([
                'transactions' => fn ($query) => $query
                    ->when(
                        $request->filled('from'),
                        fn (Builder $query) => $query->where('date', '>=', $request->from)
                    )
                    ->when(
                        $request->filled('to'),
                        fn (Builder $query) => $query->where('date', '<=', $request->to)
                    )
            ], 'amount')
            ->get();
        $out = $request->user()
            ->categories()
            ->with('children.budget')
            ->where('type', 'out')
            ->withSum([
                'transactions' => fn ($query) => $query
                    ->when(
                        $request->filled('from'),
                        fn (Builder $query) => $query->where('date', '>=', $request->from)
                    )
                    ->when(
                        $request->filled('to'),
                        fn (Builder $query) => $query->where('date', '<=', $request->to)
                    )
            ], 'amount')
            ->get();

        return ['out' => $this->curateCategories($out), 'in' => $this->curateCategories($in)];
    }

    private function curateCategories($categories)
    {
        $categories = $categories->keyBy('id');

        return $categories->filter(function ($category) {
            // Only root categories
            return $category['parent_category_id'] == null;
        })->map(function ($root_category) use ($categories) {
            return $this->sum_children($root_category, $categories);
        })->sortBy('name')->values()->all();
    }

    /**
     * @param $categories
     * @return \Closure
     */
    function getManipulateChildClosure($categories): \Closure
    {
        return function ($child_category) use ($categories) {
            $child_category['transactions_sum_amount'] = $categories[$child_category['id']]['transactions_sum_amount'];
            $child_category['children'] = $child_category['children']->map($this->getManipulateChildClosure($categories));
            return $child_category;
        };
    }

    function sum_children(Category $category, Collection $full_categories): Category
    {
        $sum = 0;
        $category['children'] = $category['children']->map(function ($child_category) use ($full_categories, &$sum) {
            $child_category['transactions_sum_amount'] = $full_categories[$child_category['id']]['transactions_sum_amount'];
            $child_category = $this->sum_children($child_category, $full_categories);
            $sum += $child_category['transactions_sum_amount'];
            return $child_category;
        });
        $category['transactions_sum_amount'] += $sum;
        return $category;
    }

    public function accounts(MakeReportRequest $request)
    {
        $accounts = $request->user()->accounts()
            ->with('type')
            ->withSum([
                'transactions as from_balance' => fn ($query) => $query
                    ->when(
                        $request->filled('from'),
                        fn (Builder $query) => $query->where('date', '<=', $request->from)
                    )
            ], 'amount')
            ->withSum([
                'transactions as to_balance' => fn ($query) => $query
                    ->when(
                        $request->filled('to'),
                        fn (Builder $query) => $query->where('date', '<=', $request->to)
                    )
            ], 'amount')
            ->withSum([
                'transactions as from_balance_minus' => fn ($query) => $query
                    ->when(
                        $request->filled('from'),
                        fn (Builder $query) => $query->where('date', '<=', $request->from)
                    )
                    ->whereHas('category', function (Builder $query) {
                        $query->where('type', '=', 'out');
                    })
            ], 'amount')
            ->withSum([
                'transactions as to_balance_minus' => fn ($query) => $query
                    ->when(
                        $request->filled('to'),
                        fn (Builder $query) => $query->where('date', '<=', $request->to)
                    )
                    ->whereHas('category', function (Builder $query) {
                        $query->where('type', '=', 'out');
                    })
            ], 'amount')
            ->get();

        return $accounts->map(function ($account) use ($request) {
            if (!$request->filled('from'))
                $account['from_balance'] = $account['initial_balance'];
            else {
                $account['from_balance'] += $account['initial_balance'];
                $account['from_balance'] -= $account['from_balance_minus'];
                $account['from_balance'] -= $account['from_balance_minus'];
            }
            $account['to_balance'] = $account['to_balance'] + $account['initial_balance'];
            $account['to_balance'] -= $account['to_balance_minus'];
            $account['to_balance'] -= $account['to_balance_minus'];
            $account['delta'] = $account['to_balance'] - $account['from_balance'];

            $account['color'] = '#'.$account['color'];
            $type = $account['type']['type'];
            unset($account['type']);
            $account['type'] = $type;

            return $account;
        });
    }

    public function properties(MakeReportRequest $request)
    {
        $properties = $request->user()->properties()
            ->withSum([
                'variations as from_value' => fn ($query) => $query
                    ->when(
                        $request->filled('from'),
                        fn (Builder $query) => $query->where('date', '<=', $request->from)
                    )
            ], 'amount')
            ->withSum([
                'variations as to_value' => fn ($query) => $query
                    ->when(
                        $request->filled('to'),
                        fn (Builder $query) => $query->where('date', '<=', $request->to)
                    )
            ], 'amount')
            ->withSum([
                'variations as from_value_minus' => fn ($query) => $query
                    ->when(
                        $request->filled('from'),
                        fn (Builder $query) => $query->where('date', '<=', $request->from)
                    )
                    ->where('type', '=', 'out')
            ], 'amount')
            ->withSum([
                'variations as to_value_minus' => fn ($query) => $query
                    ->when(
                        $request->filled('to'),
                        fn (Builder $query) => $query->where('date', '<=', $request->to)
                    )
                    ->where('type', '=', 'out')
            ], 'amount')
            ->get();

        return $properties->map(function ($property) use ($request) {
            if (!$request->filled('from'))
                $property['from_value'] = $property['initial_value'];
            else {
                $property['from_value'] += $property['initial_value'];
                $property['from_value'] -= $property['from_value_minus'];
                $property['from_value'] -= $property['from_value_minus'];
            }
            $property['to_value'] = $property['to_value'] + $property['initial_value'];
            $property['to_value'] -= $property['to_value_minus'];
            $property['to_value'] -= $property['to_value_minus'];
            $property['delta'] = $property['to_value'] - $property['from_value'];

            return $property;
        });
    }
}
