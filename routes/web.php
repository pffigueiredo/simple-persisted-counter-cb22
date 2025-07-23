<?php

use App\Http\Controllers\CounterController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/health-check', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now()->toISOString(),
    ]);
})->name('health-check');

// Counter routes - main functionality on home page
Route::controller(CounterController::class)->group(function () {
    Route::get('/', 'index')->name('counter.index');
    Route::post('/', 'store')->name('counter.store');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
