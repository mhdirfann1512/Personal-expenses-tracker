<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ExpenseController;


// Route Public (Tak perlu token)
Route::post('/login', [AuthController::class, 'login']);

// Route Protected (Kena ada Bearer Token)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/expenses', [ExpenseController::class, 'index']);
    Route::post('/logout', [AuthController::class, 'logout']);
});
