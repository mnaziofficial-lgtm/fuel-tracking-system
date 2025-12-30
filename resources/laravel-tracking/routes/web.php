<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

// Home route
Route::get('/', function () {
    return view('welcome');
});

// Admin routes
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::resource('pumps', AdminController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
    Route::resource('sales', AdminController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
});

// Authentication routes
Auth::routes();

// Additional routes can be added here as needed
