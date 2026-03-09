<?php

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ExpenseController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// 1. Route Public (Tak perlu token - untuk Login sahaja)
Route::post('/login', [AuthController::class, 'login']);

// 2. Route Protected (Semua kat dalam ni WAJIB ada Bearer Token)
Route::middleware('auth:sanctum')->group(function () {
    
    // Ambil semua perbelanjaan & Simpan perbelanjaan baru
    Route::get('/expenses', [ExpenseController::class, 'index']);
    Route::post('/expenses', [ExpenseController::class, 'store']);

    Route::put('/expenses/{id}', [ExpenseController::class, 'update']);
    Route::delete('/expenses/{id}', [ExpenseController::class, 'destroy']);
    
    // Ambil senarai kategori untuk dropdown kat Flutter
    Route::get('/categories', function () {
        // Kita guna ->unique('name') supaya kalau ada nama sama, dia buang
        return response()->json([
            'data' => Category::all()->unique('name')->values() 
        ]);
    });

    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);
});