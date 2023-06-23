<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransferRequest;
use App\Http\Resources\TransferResource;
use App\Models\Transfer;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class TransferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        return TransferResource::collection($request->user()->transfers()->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTransferRequest $request): TransferResource
    {
        $transfer = new Transfer();
        $transfer->from_account_id = $request->from_account_id;
        $transfer->to_account_id = $request->to_account_id;
        $transfer->notes = $request->notes;
        $transfer->amount = $request->amount;
        $transfer->date = $request->date;
        $transfer->save();
        $transfer->load(['from_account', 'to_account']);
        return new TransferResource($transfer);
    }

    /**
     * Display the specified resource.
     */
    public function show(Transfer $transfer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreTransferRequest $request, Transfer $transfer)
    {
        $transfer->from_account_id = $request->from_account_id;
        $transfer->to_account_id = $request->to_account_id;
        $transfer->notes = $request->notes;
        $transfer->amount = $request->amount;
        $transfer->date = $request->date;
        $transfer->save();
        $transfer->load(['from_account', 'to_account']);
        return new TransferResource($transfer);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Transfer $transfer): Response
    {
        if ($transfer->to_account->user_id != $request->user()->id)
            return response()->noContent(404);

        $transfer->delete();
        return response()->noContent();
    }
}
