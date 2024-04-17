<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExpenseController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->name('auth.')->group(function () {
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum')->name('logout');
    Route::get('/me', [AuthController::class, 'me'])->middleware('auth:sanctum')->name('me');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('expenses', ExpenseController::class)->middleware('auth:sanctum');
    Route::get('/status/expenses', [ExpenseController::class, 'status'])->middleware('auth:sanctum')->name('expenses.status');
});


