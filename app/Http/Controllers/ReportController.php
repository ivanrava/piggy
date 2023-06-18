<?php

namespace App\Http\Controllers;

use App\Http\Requests\MakeReportRequest;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ReportController extends Controller
{
    public function report(MakeReportRequest $request): AnonymousResourceCollection
    {
        return TransactionResource::collection(
            $request->user()->transaction()
                ->orderBy($request->sort, $request->direction)
                ->when($request->has('from'), fn (Builder $query) => $query->where('date', '>=', $request->from))
                ->when($request->has('to'), fn (Builder $query) => $query->where('date', '<=', $request->to))
                ->get()
        );
    }
}
