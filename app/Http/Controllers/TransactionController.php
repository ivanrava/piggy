<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthorizeTransactionRequest;
use App\Http\Requests\StoreTransactionRequest;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        return TransactionResource::collection($request->user()->transactions()->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTransactionRequest $request): TransactionResource
    {
        $transaction = Transaction::fromRequest($request);
        $transaction->save();
        return new TransactionResource($transaction);
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreTransactionRequest $request, Transaction $transaction): TransactionResource
    {
        $transaction->hydrateFromRequest($request);
        $transaction->save();
        return new TransactionResource($transaction);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AuthorizeTransactionRequest $request, Transaction $transaction): Response
    {
        $transaction->delete();
        return response()->noContent();
    }
}
