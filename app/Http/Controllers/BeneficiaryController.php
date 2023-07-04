<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthorizeBeneficiaryRequest;
use App\Http\Requests\StoreBeneficiaryRequest;
use App\Http\Resources\BeneficiaryResource;
use App\Models\Beneficiary;
use App\Models\Stats\CrossStats;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class BeneficiaryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        return BeneficiaryResource::collection($request->user()->beneficiaries()->orderBy('name')->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBeneficiaryRequest $request): BeneficiaryResource
    {
        $beneficiary = Beneficiary::fromRequest($request);
        $beneficiary->save();
        return new BeneficiaryResource($beneficiary);
    }

    /**
     * Display the specified resource.
     */
    public function show(AuthorizeBeneficiaryRequest $request, Beneficiary $beneficiary): Response|BeneficiaryResource
    {
        $beneficiary->load('transactions');

        return new BeneficiaryResource($beneficiary);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreBeneficiaryRequest $request, Beneficiary $beneficiary): Response
    {
        $beneficiary->hydrateFromRequest($request);
        $beneficiary->save();
        return response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AuthorizeBeneficiaryRequest $request, Beneficiary $beneficiary): Response
    {
        $beneficiary->delete();
        return response()->noContent();
    }

    public function stats_categories(AuthorizeBeneficiaryRequest $request, Beneficiary $beneficiary): Collection|Response|array
    {
        return CrossStats::get_category_stats_for($beneficiary->transactions());
    }

    public function stats_accounts(AuthorizeBeneficiaryRequest $request, Beneficiary $beneficiary): Collection|Response|array
    {
        return CrossStats::get_account_stats_for($beneficiary->transactions());
    }
}
