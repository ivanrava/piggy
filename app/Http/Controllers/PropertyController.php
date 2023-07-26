<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePropertyRequest;
use App\Http\Resources\PropertyResource;
use App\Models\Property;
use App\Models\PropertyVariation;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PropertyController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $properties = $request->user()->properties()->with('variations')->orderBy('name')->get();
        $properties->each(function (Property $property) {
            $sum = $property['initial_value'];
            $property['variations']->each(function (PropertyVariation $variation) use (&$sum) {
                $sum = $sum + ($variation['type'] == 'out' ? -$variation['amount'] : $variation['amount']);
                $variation['value'] = $sum;
            });
        });
        return PropertyResource::collection($properties);
    }

    public function store(StorePropertyRequest $request): PropertyResource
    {
        $property = new Property();
        $property->initial_value = $request->initial_value;
        $property = $this->hydrate_from_request($property, $request);
        $property->save();
        return new PropertyResource($property->load('variations'));
    }

    private function hydrate_from_request(Property $property, Request $request): Property
    {
        $property->user_id = $request->user()->id;
        $property->name = $request->name;
        $property->icon = $request->icon;
        $property->description = $request->description;
        return $property;
    }
}
