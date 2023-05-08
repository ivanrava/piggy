<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBeneficiaryRequest;
use App\Http\Resources\BeneficiaryResource;
use App\Models\Beneficiary;
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
        return BeneficiaryResource::collection($request->user()->beneficiaries()->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBeneficiaryRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Beneficiary $beneficiary): Response|BeneficiaryResource
    {
        if ($beneficiary->user_id != $request->user()->id)
            return response()->noContent(404);

        return new BeneficiaryResource($beneficiary);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreBeneficiaryRequest $request, Beneficiary $beneficiary)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Beneficiary $beneficiary)
    {
        //
    }
}
