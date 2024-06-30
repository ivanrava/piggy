<?php

namespace App\Http\Controllers;

use App\Http\Requests\TokenCreateRequest;
use App\Http\Requests\TokenRegisterRequest;
use App\Http\Requests\TokenRevokeRequest;
use App\Models\User;
use Hash;
use Illuminate\Validation\ValidationException;

class TokenController extends Controller
{
    /**
     * @throws ValidationException
     */
    public function create(TokenCreateRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.']
            ]);
        }

        return response()->json([
            'token' => $user->createToken($request->device_name)->plainTextToken
        ]);
    }

    public function register(TokenRegisterRequest $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json([
            'token' => $user->createToken($request->device_name)->plainTextToken
        ]);
    }

    public function revoke(TokenRevokeRequest $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'token' => $request->bearerToken()
        ]);
    }
}
