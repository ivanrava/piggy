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
    public function store(StoreAccountRequest $request): Response
    {
        $account = new Account();
        $account->initial_balance = $request->initial_balance;
        $account->user_id = $request->user()->id;
        $account->account_type_id = $request->account_type_id;
        $account->name = $request->name;
        $account->icon = $request->icon;
        $account->color = $request->color;
        $account->opening = $request->opening;
        $account->closing = $request->closing;
        $account->description = $request->description;
        $account->save();
        return response()->noContent(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Account $account): AccountResource
    {
        return new AccountResource($account);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAccountRequest $request, Account $account): Response
    {
        $account->user_id = $request->user()->id;
        $account->account_type_id = $request->account_type_id;
        $account->name = $request->name;
        $account->icon = $request->icon;
        $account->color = $request->color;
        $account->opening = $request->opening;
        $account->closing = $request->closing;
        $account->description = $request->description;
        $account->save();
        return response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Account $account): Response
    {
        $account->delete();
        return response()->noContent();
    }
}
