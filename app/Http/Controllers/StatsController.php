<?php

namespace App\Http\Controllers;

use App\Models\Category;
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
            ->when(Str($request->path())->endsWith('top'), fn ($query) => $query->take(5))
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
            ->when(Str($request->path())->endsWith('top'), fn ($query) => $query->take(5))
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
            ->when(Str($request->path())->endsWith('top'), fn ($query) => $query->take(5))
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
            ->when(Str($request->path())->endsWith('top'), fn ($query) => $query->take(5))
            ->get()
            ->makeHidden(['beneficiary'])
            ->toJson();
    }

    public function accounts(Request $request)
    {
        return $request->user()
            ->transactions()
            ->join('accounts', 'accounts.id', '=', 'transactions.category_id')
            ->join('account_types', 'account_types.id', '=', 'accounts.account_type_id')
            ->selectRaw('count(*)')
            ->selectRaw('avg(transactions.amount)')
            ->selectRaw('min(transactions.amount)')
            ->selectRaw('max(transactions.amount)')
            ->selectRaw('sum(transactions.amount)')
            ->selectRaw('accounts.name')
            ->selectRaw('accounts.color')
            ->selectRaw('accounts.icon')
            ->selectRaw('accounts.id')
            ->selectRaw('account_types.type')
            ->groupBy(['accounts.id', 'accounts.icon', 'accounts.color', 'accounts.name', 'account_types.type'])
            ->orderBy('count', 'DESC')
            ->when(Str($request->path())->endsWith('top'), fn ($query) => $query->take(5))
            ->get()
            ->makeHidden(['beneficiary'])
            ->toJson();
    }
}
