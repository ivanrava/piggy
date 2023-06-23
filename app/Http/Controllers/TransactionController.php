<?php

namespace App\Http\Controllers;

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
        $transaction = new Transaction();
        $transaction->account_id = $request->account_id;

        $beneficiary = $request->beneficiary();
        $beneficiary->save();
        $transaction->beneficiary_id = $beneficiary->id;

        $category = $request->category();
        $category->save();
        $transaction->category_id = $category->id;

        $transaction->notes = $request->notes;
        $transaction->amount = $request->amount;
        $transaction->date = $request->date;
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
        $transaction->account_id = $request->account_id;

        $beneficiary = $request->beneficiary();
        $beneficiary->save();
        $transaction->beneficiary_id = $beneficiary->id;

        $category = $request->category();
        $category->save();
        $transaction->category_id = $category->id;

        $transaction->notes = $request->notes;
        $transaction->amount = $request->amount;
        $transaction->date = $request->date;
        $transaction->save();
        return new TransactionResource($transaction);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Transaction $transaction): Response
    {
        if ($transaction->beneficiary->user_id != $request->user()->id)
            return response()->noContent(404);

        $transaction->delete();
        return response()->noContent();
    }
}
