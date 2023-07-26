<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePropertyVariationRequest;
use App\Http\Resources\PropertyVariationResource;
use App\Models\Property;
use App\Models\PropertyVariation;
use Illuminate\Http\Request;

class PropertyVariationController extends Controller
{
    public function store(StorePropertyVariationRequest $request, Property $property): PropertyVariationResource
    {
        $propertyVariation = PropertyVariation::fromRequest($request);
        $property->variations()->save($propertyVariation);
        return new PropertyVariationResource($propertyVariation);
    }
}
