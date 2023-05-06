<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAccountTypeRequest;
use App\Http\Requests\UpdateAccountTypeRequest;
use App\Models\AccountType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class AccountTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return response()->json(AccountType::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAccountTypeRequest $request): Response
    {
        AccountType: $account_type = new AccountType();
        $account_type->type = $request->type;
        $account_type->save();
        return response()->noContent(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(AccountType $accountType): JsonResponse
    {
        return response()->json($accountType);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAccountTypeRequest $request, AccountType $accountType): Response
    {
        $accountType->type = $request->type;
        $accountType->save();
        return response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AccountType $accountType): Response
    {
        $accountType->delete();
        return response()->noContent();
    }
}
