<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ServiceDirectoryController;
use App\Http\Controllers\Api\ExpertProfileController;
use App\Http\Controllers\Api\WorkingHourController;
use App\Http\Controllers\Api\ExpertStatisticController;
use App\Http\Controllers\Api\ReviewController;

// --- AREA PUBLIK ---
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Route untuk melihat daftar kategori dan jasa (Publik, bisa dipanggil oleh FE untuk menampilkan direktori jasa)
Route::get('/categories', [ServiceDirectoryController::class, 'getCategories']);
Route::get('/services', [ServiceDirectoryController::class, 'getServices']);

// Route untuk melihat daftar dan detail profil ahli (Publik)
Route::get('/experts', [ExpertProfileController::class, 'index']);
Route::get('/experts/{id}', [ExpertProfileController::class, 'show']);

// Route untuk mendapatkan link WhatsApp (Publik)
Route::get('/experts/{id}/whatsapp', [ExpertProfileController::class, 'getWhatsappLink']);

// Route untuk mencatat klik (Publik, dipanggil oleh Frontend secara diam-diam)
Route::post('/experts/{id}/track-click', [ExpertStatisticController::class, 'trackClick']);

// Route untuk melihat review ahli (Publik)
Route::get('/experts/{id}/reviews', [ReviewController::class, 'getReviews']);


// --- AREA PRIVATE (Butuh Token Login) ---
Route::middleware('auth:sanctum')->group(function () {
    
    Route::get('/user', function (Request $request) {
        return $request->user();
    })->name('user');
    // Route untuk Logout (Hanya untuk yang sudah login)
    Route::post('/logout', [AuthController::class, 'logout']); 
    
    // Route untuk mengupdate profil ahli (Hanya untuk ahli yang login)
    Route::post('/experts/profile', [ExpertProfileController::class, 'updateProfile']);

    // Route untuk mengupdate jadwal kerja ahli (Hanya untuk ahli yang login)
    Route::post('/experts/working-hours', [WorkingHourController::class, 'updateSchedule']);

    // Route untuk mendapatkan statistik klik (Hanya untuk ahli yang login melihat dashboard mereka)
    Route::get('/experts/stats', [ExpertStatisticController::class, 'getStats']);

    // Route untuk memberikan review (Hanya untuk customer yang login)
    Route::post('/experts/{id}/reviews', [ReviewController::class, 'store']);
    
});