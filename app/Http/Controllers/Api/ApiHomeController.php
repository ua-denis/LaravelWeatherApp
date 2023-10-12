<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\HomeService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use JsonException;

class ApiHomeController extends Controller
{
    /**
     * @throws JsonException|Exception
     */
    public function __invoke(HomeService $homeService): JsonResponse
    {
        return response()->json($homeService->getData());
    }
}
