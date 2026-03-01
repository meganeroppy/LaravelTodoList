<?php
// Copyright 2026 roppy

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;

// トップページ（Laravelデフォルト）
Route::get('/', function () {
    return view('welcome');
});

// ToDoアプリのルート
Route::get('/todo', [TodoController::class, 'index']);          // 一覧
Route::post('/todo', [TodoController::class, 'store']);         // 新規保存
Route::delete('/todo/{todo}', [TodoController::class, 'destroy']); // 削除
