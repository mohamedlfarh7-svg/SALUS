<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\SymptomController;
use App\Http\Controllers\Api\AIController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/test', function () {
    return response()->json(['message' => 'Hello World, API is running!']);
});

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/me', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [AuthController::class, 'logout']);


    Route::apiResource('symptoms', SymptomController::class);

    Route::post('/symptoms/{id}/advice', [AIController::class, 'getHealthAdvice']);


});