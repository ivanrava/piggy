<?php

namespace App\Models\Stats;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CrossStats
{
    public static function get_account_stats_for(Builder|HasMany $transactions): Collection|array
    {
        return $transactions
            ->join('accounts', 'accounts.id', '=', 'transactions.account_id')
            ->groupBy(['accounts.name', 'accounts.color'])
            ->selectRaw('accounts.name, accounts.color, SUM(amount) as sum, COUNT(*) as count')
            ->get();
    }

    public static function get_beneficiary_stats_for(Builder|HasMany $transactions): Collection|array
    {
        return $transactions
            ->join('beneficiaries', 'beneficiaries.id', '=', 'transactions.beneficiary_id')
            ->groupBy(['beneficiaries.name'])
            ->selectRaw('beneficiaries.name, SUM(amount) as sum, COUNT(*) as count')
            ->get();
    }

    public static function get_category_stats_for(Builder|HasMany $transactions): Collection|array
    {
        return $transactions
            ->join('categories', 'categories.id', '=', 'transactions.category_id')
            ->groupBy(['categories.name'])
            ->selectRaw('categories.name, SUM(amount) as sum, COUNT(*) as count')
            ->get();
    }
}
