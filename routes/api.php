<?php

use Illuminate\Support\Facades\Route;

Route::post('/login', 'App\Http\Controllers\Api\AuthController@login');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/todos', 'App\Http\Controllers\Api\TodoApiController@index');
    Route::post('/logout', 'App\Http\Controllers\Api\AuthController@logout');
});