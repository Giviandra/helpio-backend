<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController; // Jangan lupa import Controller-nya
use App\Http\Controllers\Api\ServiceDirectoryController;

// 1. Route API Publik (Tidak perlu login untuk mengaksesnya)
Route::post('/register', [AuthController::class, 'register']);
Route::get('/categories', [ServiceDirectoryController::class, 'getCategories']);
Route::get('/services', [ServiceDirectoryController::class, 'getServices']);    

// 2. Route API Private (Hanya bisa diakses kalau punya token/sudah login)
// Kode bawaan Laravel yang sudah diperbaiki penulisan name()-nya
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum')->name('user');