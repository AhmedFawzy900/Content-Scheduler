<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Web\PostController;
use App\Http\Controllers\Web\PlatformController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Web\DashboardController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);
});

Route::post('logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Post Management Routes
    Route::resource('posts', PostController::class);
    Route::get('/analytics', [PostController::class, 'analytics'])->name('analytics');

    // Platform Management Routes
    Route::resource('platforms', PlatformController::class);
});
