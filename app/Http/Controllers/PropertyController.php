<?php

namespace App\Http\Controllers;

use App\Http\Resources\PropertyResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PropertyController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $properties = $request->user()->properties()->with('variations')->get();
        return PropertyResource::collection($properties);
    }
}
