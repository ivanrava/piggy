<?php

namespace App\Http\Controllers;

use App\Http\Requests\MakeReportRequest;
use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class ReportController extends Controller
{
    public function report(MakeReportRequest $request): array
    {
        $in = $request->user()
            ->categories()
            ->where('type', 'in')
            ->withSum([
                'transactions' => fn ($query) => $query
                    ->when(
                        $request->has('from'),
                        fn (Builder $query) => $query->where('date', '>=', $request->from)
                    )
                    ->when(
                        $request->has('to'),
                        fn (Builder $query) => $query->where('date', '<=', $request->to)
                    )
            ], 'amount')
            ->get();
        $out = $request->user()
            ->categories()
            ->where('type', 'out')
            ->withSum([
                'transactions' => fn ($query) => $query
                    ->when(
                        $request->has('from'),
                        fn (Builder $query) => $query->where('date', '>=', $request->from)
                    )
                    ->when(
                        $request->has('to'),
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
}
