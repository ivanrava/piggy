<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthorizeAccountRequest;
use App\Http\Requests\StoreAccountRequest;
use App\Http\Requests\UpdateAccountRequest;
use App\Http\Resources\AccountResource;
use App\Models\Account;
use App\Models\Stats\CrossStats;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class AccountController extends Controller
{
    private function hydrate_from_request(Account $account, Request $request): Account
    {
        $account->user_id = $request->user()->id;
        $account->account_type_id = $request->account_type_id;
        $account->name = $request->name;
        $account->icon = $request->icon;
        $account->color = $request->color();
        $account->opening = $request->opening;
        $account->closing = $request->closing;
        $account->description = $request->description;
        return $account;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        return AccountResource::collection($request->user()->accounts()->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAccountRequest $request): AccountResource
    {
        $account = new Account();
        $account->initial_balance = $request->initial_balance;
        $account = $this->hydrate_from_request($account, $request);
        $account->save();
        return new AccountResource($account);
    }

    /**
     * Display the specified resource.
     */
    public function show(AuthorizeAccountRequest $request, Account $account): Response|AccountResource
    {
        return new AccountResource($account->load([
            'transactions' => [
                'beneficiary',
                'category'
            ],
            'in_transfers' => [
                'from_account'
            ],
            'out_transfers' => [
                'to_account'
            ]
        ]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAccountRequest $request, Account $account): AccountResource
    {
        $account = $this->hydrate_from_request($account, $request);
        $account->save();
        return new AccountResource($account);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AuthorizeAccountRequest $request, Account $account): Response
    {
        $account->delete();
        return response()->noContent();
    }

    public function stats_categories(AuthorizeAccountRequest $request, Account $account): Collection|Response|array
    {
        return CrossStats::get_category_stats_for(
            $account->transactions()
                ->when($request->interval != 'all', function ($query) use ($request) {
                    if ($request->interval == 'year')
                        return $query->where('date', '>=', Carbon::now()->subYear());
                    if ($request->interval == 'month')
                        return $query->where('date', '>=', Carbon::now()->subMonth());
                    return $query;
                })
        );
    }

    public function stats_beneficiaries(AuthorizeAccountRequest $request, Account $account): Collection|Response|array
    {
        return CrossStats::get_beneficiary_stats_for(
            $account->transactions()
                ->when($request->interval != 'all', function ($query) use ($request) {
                    if ($request->interval == 'year')
                        return $query->where('date', '>=', Carbon::now()->subYear());
                    if ($request->interval == 'month')
                        return $query->where('date', '>=', Carbon::now()->subMonth());
                    return $query;
                })
        );
    }
}
