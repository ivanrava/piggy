<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StatsController extends Controller
{
    public function year(Request $request)
    {
        return $request->user()
            ->transactions()
            ->selectRaw("date_part('year', date) as year")
            ->selectRaw("avg(amount)")
            ->selectRaw("count(amount)")
            ->selectRaw("sum(amount)")
            ->selectRaw("min(amount)")
            ->selectRaw("max(amount)")
            ->groupBy("year")
            ->orderBy('year', 'DESC')
            ->get()
            ->makeHidden(['beneficiary'])
            ->toJson();
    }

    public function month(Request $request)
    {
        return $request->user()
            ->transactions()
            ->selectRaw("date_trunc('month', date) as month")
            ->selectRaw("avg(amount)")
            ->selectRaw("count(amount)")
            ->selectRaw("sum(amount)")
            ->selectRaw("min(amount)")
            ->selectRaw("max(amount)")
            ->groupBy("month")
            ->orderBy('month', 'DESC')
            ->get()
            ->makeHidden(['beneficiary'])
            ->toJson();
    }

    public function beneficiaries(Request $request)
    {
        return $request->user()
            ->transactions()
            ->join('beneficiaries', 'beneficiaries.id', '=', 'transactions.beneficiary_id')
            ->selectRaw('count(*)')
            ->selectRaw('avg(transactions.amount)')
            ->selectRaw('min(transactions.amount)')
            ->selectRaw('max(transactions.amount)')
            ->selectRaw('sum(transactions.amount)')
            ->selectRaw('beneficiaries.name')
            ->selectRaw('beneficiaries.img')
            ->groupBy(['beneficiaries.name', 'beneficiaries.img'])
            ->orderBy('count', 'DESC')
            ->get()
            ->makeHidden(['beneficiary'])
            ->toJson();
    }

    public function categories(Request $request)
    {
        return $request->user()
            ->transactions()
            ->join('categories', 'categories.id', '=', 'transactions.category_id')
            ->selectRaw('count(*)')
            ->selectRaw('avg(transactions.amount)')
            ->selectRaw('min(transactions.amount)')
            ->selectRaw('max(transactions.amount)')
            ->selectRaw('sum(transactions.amount)')
            ->selectRaw('categories.name')
            ->selectRaw('categories.type')
            ->groupBy(['categories.name', 'categories.type'])
            ->orderBy('count', 'DESC')
            ->get()
            ->makeHidden(['beneficiary'])
            ->toJson();
    }
}
