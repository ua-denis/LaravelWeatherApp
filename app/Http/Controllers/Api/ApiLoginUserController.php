<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ApiLoginUserController extends Controller
{
    /**
     * @throws ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        if (!Auth::guard('api')->attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid credentials',
            ], 401);
        }

        $token = Auth::guard('api')->user()?->createToken('api-auth-token');

        return response()->json([
            'token' => $token->plainTextToken,
            'message' => 'Logged in successfully',
        ]);
    }
}
