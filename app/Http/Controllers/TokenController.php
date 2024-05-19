<?php

namespace App\Http\Controllers;

use App\Http\Requests\TokenRequest;
use App\Models\User;
use Hash;
use Illuminate\Validation\ValidationException;

class TokenController extends Controller
{
    /**
     * @throws ValidationException
     */
    public function token(TokenRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.']
            ]);
        }

        return $user->createToken($request->device_name)->plainTextToken;
    }
}
