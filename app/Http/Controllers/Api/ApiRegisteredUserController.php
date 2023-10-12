<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\UserRegisteredRequest;
use App\Providers\RouteServiceProvider;
use App\Services\UserService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ApiRegisteredUserController extends Controller
{
    public function store(UserRegisteredRequest $request, UserService $userService): JsonResponse
    {
        $user = $userService->create($request->getDto());

        $token = $user->createToken('api-auth-token');

        return response()->json([
            'token' => $token->plainTextToken,
            'message' => 'User was created successfully',
        ]);
    }
}
