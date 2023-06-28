<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class StatsController extends Controller
{
    public function year(Request $request)
    {
        return $request->user()
            ->transactions()
            ->join('categories', 'categories.id', '=', 'transactions.category_id')
            ->when($request->route('id'), function ($query) use ($request) {
                $path = Str($request->path());
                if ($path->contains('categories')) {
                    return $query->where('category_id', $request->id);
                } else if ($path->contains('beneficiaries')) {
                    return $query->where('beneficiary_id', $request->id);
                } else if ($path->contains('accounts')) {
                    return $query->where('account_id', $request->id);
                } else {
                    return $query;
                }
            })
            ->selectRaw("date_part('year', date) as time")
            ->selectRaw("avg(amount)")
            ->selectRaw("count(amount)")
            ->selectRaw("sum(amount)")
            ->selectRaw("min(amount)")
            ->selectRaw("max(amount)")
            ->selectRaw("type")
            ->groupBy(["time", "type"])
            ->orderBy('time', 'ASC')
            ->when(Str($request->path())->endsWith('top'), fn ($query) => $query->take(5))
            ->get()
            ->makeHidden(['beneficiary'])
            ->toJson();
    }

    public function month(Request $request)
    {
        return $request->user()
            ->transactions()
            ->join('categories', 'categories.id', '=', 'transactions.category_id')
            ->when($request->route('id'), function ($query) use ($request) {
                $path = Str($request->path());
                if ($path->contains('categories')) {
                    return $query->where('category_id', $request->id);
                } else if ($path->contains('beneficiaries')) {
                    return $query->where('beneficiaries_id', $request->id);
                } else if ($path->contains('accounts')) {
                    return $query->where('accounts_id', $request->id);
                } else {
                    return $query;
                }
            })
            ->selectRaw("date_trunc('month', date) as time")
            ->selectRaw("avg(amount)")
            ->selectRaw("count(amount)")
            ->selectRaw("sum(amount)")
            ->selectRaw("min(amount)")
            ->selectRaw("max(amount)")
            ->selectRaw("type")
            ->where('date', '>=', Carbon::now()->subYear())
            ->groupBy(["time", "type"])
            ->orderBy('time', 'ASC')
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
            ->selectRaw('categories.icon')
            ->groupBy(['categories.name', 'categories.type', 'categories.icon'])
            ->orderBy('sum', 'DESC')
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
            ->orderBy('sum', 'DESC')
            ->when(Str($request->path())->endsWith('top'), fn ($query) => $query->take(5))
            ->get()
            ->makeHidden(['beneficiary'])
            ->toJson();
    }
}
