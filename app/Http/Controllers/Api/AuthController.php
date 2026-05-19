<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Fungsi untuk Register
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'in:admin,customer,expert' // Validasi role
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            // Jika role tidak dikirim, otomatis jadi 'customer'
            'role' => $request->role ?? 'customer', 
            'phone_number' => $request->phone_number,
        ]);

        // Buat token Sanctum untuk API
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'User berhasil didaftarkan',
            'data' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer'
        ], 201);
    }
}
