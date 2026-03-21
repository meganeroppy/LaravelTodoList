<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TodoApiController;

// 公開ルート (Unityログイン用)
Route::post('/login', [AuthController::class, 'login']);

// 認証済みルート (Bearer Tokenが必要)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    
    Route::get('/todos', [TodoApiController.class, 'index']);
    Route::post('/logout', [AuthController.class, 'logout']);
});
