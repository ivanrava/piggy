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
        return BeneficiaryResource::collection($request->user()->beneficiaries()->orderBy('name')->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBeneficiaryRequest $request): Response
    {
        $beneficiary = new Beneficiary();
        $beneficiary->user_id = $request->user()->id;
        $beneficiary->name = $request->name;
        $beneficiary->img = $request->img;
        $beneficiary->save();
        return response()->noContent(201);
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
    public function update(StoreBeneficiaryRequest $request, Beneficiary $beneficiary): Response
    {
        $beneficiary->user_id = $request->user()->id;
        $beneficiary->name = $request->name;
        $beneficiary->img = $request->img;
        $beneficiary->save();
        return response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Beneficiary $beneficiary): Response
    {
        if ($beneficiary->user_id != $request->user()->id)
            return response()->noContent(404);

        $beneficiary->delete();
        return response()->noContent();
    }
}
