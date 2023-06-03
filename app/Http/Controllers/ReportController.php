<?php

namespace App\Http\Controllers;

use App\Http\Requests\MakeReportRequest;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ReportController extends Controller
{
    public function report(MakeReportRequest $request): AnonymousResourceCollection
    {
        return TransactionResource::collection(
            Transaction::whereBetween('date', [$request->from, $request->to])
                ->orderBy('date')
                ->get()
        );
    }
}
