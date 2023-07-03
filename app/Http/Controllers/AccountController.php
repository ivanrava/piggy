<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAccountRequest;
use App\Http\Requests\UpdateAccountRequest;
use App\Http\Resources\AccountResource;
use App\Models\Account;
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
    public function show(Request $request, Account $account): Response|AccountResource
    {
        if ($account->user_id != $request->user()->id)
            return response()->noContent(404);

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
    public function destroy(Request $request, Account $account): Response
    {
        if ($account->user_id != $request->user()->id)
            return response()->noContent(404);

        $account->delete();
        return response()->noContent();
    }
}
