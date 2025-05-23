<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\PlatformController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // // User Profile
    Route::get('/user', [AuthController::class, 'profile']);
    Route::post('/user', [AuthController::class, 'updateProfile']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // // Posts
    Route::apiResource('posts-api', PostController::class);
    Route::get('/posts/analytics', [PostController::class, 'analytics']);

    // // Platforms
   Route::get('/platforms', [PlatformController::class, 'index']);
    Route::put('/platforms/{platform}/toggle-active', [PlatformController::class, 'toggleActive']);
}); 