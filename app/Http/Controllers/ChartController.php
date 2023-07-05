<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreChartRequest;
use App\Http\Requests\UpdateChartRequest;
use App\Http\Resources\ChartResource;
use App\Models\Chart;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ChartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        return ChartResource::collection($request->user()->charts()->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreChartRequest $request): ChartResource
    {
        $chart = new Chart();
        $chart->user_id = $request->user()->id;
        $chart->kind = $request->kind;
        $chart->interval = $request->interval;
        $chart->stat = $request->stat;
        $chart->filter = $request->filter;
        $chart->filter_id = $request->filter_id;
        $chart->filter_group = $request->filter_group;
        $chart->save();
        return new ChartResource($chart);
    }

    /**
     * Display the specified resource.
     */
    public function show(Chart $chart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateChartRequest $request, Chart $chart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chart $chart)
    {
        //
    }
}
