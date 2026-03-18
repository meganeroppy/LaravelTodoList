<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/setup', function () {
    \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
    \Illuminate\Support\Facades\Artisan::call('db:seed', ['--force' => true]);
    return 'Database setup completed successfully! You can now go to <a href="/todo">/todo</a>';
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return redirect('/todo');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ToDo関連のルート
    Route::get('/todo', [App\Http\Controllers\TodoController::class, 'index']);
    Route::post('/todo', [App\Http\Controllers\TodoController::class, 'store']);
    Route::get('/todo/{todo}/edit', [App\Http\Controllers\TodoController::class, 'edit']);
    Route::put('/todo/{todo}', [App\Http\Controllers\TodoController::class, 'update']);
    Route::delete('/todo/completed', [App\Http\Controllers\TodoController::class, 'destroyCompleted']);
    Route::patch('/todo/{todo}/toggle', [App\Http\Controllers\TodoController::class, 'toggle']);
    Route::delete('/todo/{todo}', [App\Http\Controllers\TodoController::class, 'destroy']);
});

require __DIR__.'/auth.php';
