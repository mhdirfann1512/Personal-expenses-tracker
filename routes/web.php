<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AnalysisController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::post('/expenses', [DashboardController::class, 'store'])
    ->name('expenses.store');

Route::patch('/expenses/{expense}', [DashboardController::class, 'update'])
    ->name('expenses.update');

Route::delete('/expenses/{expense}', [DashboardController::class, 'destroy'])
    ->name('expenses.destroy');
    
Route::get('/analysis', [AnalysisController::class, 'index'])
    ->middleware(['auth'])
    ->name('analysis');

Route::post('/notes/update', [App\Http\Controllers\NoteController::class, 'update'])
    ->name('notes.update');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
