<?php

namespace App\Http\Controllers;

use App\Models\AccountType;
use Illuminate\Http\JsonResponse;

class AccountTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return response()->json(AccountType::all());
    }
}
