<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\PumpController as AdminPumpController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PumpShiftController;
use App\Http\Controllers\GovernmentCapController;
use App\Http\Controllers\CapController;




Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }

    return view('welcome');
});

// Auth routes (Laravel Breeze)
require __DIR__.'/auth.php';

// Dashboard (role handled inside controller)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Sales (both admin & attendant can access create)
    Route::get('/sales/create', [SalesController::class, 'create'])->name('sales.create');
    Route::post('/sales', [SalesController::class, 'store'])->name('sales.store');
    Route::get('/sales', [SalesController::class, 'index'])->name('sales.index');
    Route::get('/sales/download', [SalesController::class, 'download'])->name('sales.download');

    // Profile
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// Admin-only routes (checked inside controller)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [AdminUserController::class, 'create'])->name('users.create');
    Route::post('/users', [AdminUserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
    // Pumps management
    Route::get('/pumps', [AdminPumpController::class, 'index'])->name('pumps.index');
    Route::get('/pumps/create', [AdminPumpController::class, 'create'])->name('pumps.create');
    Route::post('/pumps', [AdminPumpController::class, 'store'])->name('pumps.store');
    Route::get('/pumps/{pump}/edit', [AdminPumpController::class, 'edit'])->name('pumps.edit');
    Route::put('/pumps/{pump}', [AdminPumpController::class, 'update'])->name('pumps.update');
    Route::delete('/pumps/{pump}', [AdminPumpController::class, 'destroy'])->name('pumps.destroy');
    
    // CAP File Routes
    Route::get('/cap', [CapController::class, 'index'])->name('cap.index');
    Route::post('/cap', [CapController::class, 'store'])->name('cap.store');
    Route::get('/cap/{id}/download', [CapController::class, 'download'])->name('cap.download');
    Route::delete('/cap/{id}', [CapController::class, 'destroy'])->name('cap.destroy');

    // Government CAP Upload Routes
    Route::get('/govcap-upload', [GovernmentCapController::class, 'index'])->name('govcap.upload');
    Route::post('/govcap-upload', [GovernmentCapController::class, 'upload'])->name('govcap.upload.submit');
    Route::get('/govcap-download', [GovernmentCapController::class, 'download'])->name('govcap.download');
});

// Route::get('/', function () {
//     return view('loading');
// })->name('loading');

Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');



Route::middleware(['auth'])->group(function () {
    Route::get('/shifts', [PumpShiftController::class, 'index'])->name('shifts.index');

    Route::get('/shifts/create', [PumpShiftController::class, 'create'])
        ->name('shifts.create');

    Route::post('/shifts', [PumpShiftController::class, 'store'])
        ->name('shifts.store');

    Route::get('/shifts/{shift}/close', [PumpShiftController::class, 'closeForm'])
        ->name('shifts.close.form');

    Route::post('/shifts/{shift}/close', [PumpShiftController::class, 'close'])
        ->name('shifts.close');
});


