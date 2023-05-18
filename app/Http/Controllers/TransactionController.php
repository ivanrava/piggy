<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransactionRequest;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        return TransactionResource::collection($request->user()->transactions()->all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTransactionRequest $request): \Illuminate\Http\Response
    {

        $category = new Transaction();
        $category->account_id = $request->account_id;
        $category->beneficiary_id = $request->beneficiary_id;
        $category->category_id = $request->category_id;
        $category->notes = $request->notes;
        $category->amount = $request->amount;
        $category->date = $request->date;
        $category->save();
        return response()->noContent(201);
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
    public function update(StoreTransactionRequest $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
