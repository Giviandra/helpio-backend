<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ServiceDirectoryController;
use App\Http\Controllers\Api\ExpertProfileController; // TAMBAHKAN IMPORT INI

// --- AREA PUBLIK ---
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/categories', [ServiceDirectoryController::class, 'getCategories']);
Route::get('/services', [ServiceDirectoryController::class, 'getServices']);

// Route untuk melihat daftar dan detail profil ahli (Publik)
Route::get('/experts', [ExpertProfileController::class, 'index']);
Route::get('/experts/{id}', [ExpertProfileController::class, 'show']);


// --- AREA PRIVATE (Butuh Token Login) ---
Route::middleware('auth:sanctum')->group(function () {
    
    Route::get('/user', function (Request $request) {
        return $request->user();
    })->name('user');

    Route::post('/logout', [AuthController::class, 'logout']); 
    
    // Route untuk mengupdate profil ahli (Hanya untuk ahli yang login)
    Route::post('/experts/profile', [ExpertProfileController::class, 'updateProfile']);
    
});