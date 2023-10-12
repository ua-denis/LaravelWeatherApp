<?php

use App\Http\Controllers\Api\ApiHomeController;
use App\Http\Controllers\Api\ApiLoginUserController;
use App\Http\Controllers\Api\ApiRegisteredUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->group(function () {
    Route::get('/home', ApiHomeController::class)->name('api.home');
});

Route::post('register', [ApiRegisteredUserController::class, 'store']);
Route::post('login', [ApiLoginUserController::class, 'store']);