<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\ExpertProfile;

class ReviewController extends Controller
{
    // 1. Melihat semua review untuk satu ahli (Publik)
    public function getReviews($expert_id)
    {
        $profile = ExpertProfile::where('user_id', $expert_id)->first();

        if (!$profile) {
            return response()->json(['message' => 'Profil ahli tidak ditemukan'], 404);
        }

        // Ambil review beserta nama customer yang menilainya
        $reviews = Review::where('expert_profile_id', $profile->id)
                         ->with('user:id,name') // Hanya ambil id dan nama dari tabel users
                         ->latest()
                         ->get();

        return response()->json([
            'message' => 'Berhasil mengambil ulasan',
            'data' => $reviews
        ]);
    }

    // 2. Memberikan Review (Hanya untuk Customer yang login)
    public function store(Request $request, $expert_id)
    {
        $user = $request->user();

        // Validasi: Hanya customer yang bisa memberi review
        if ($user->role !== 'customer') {
            return response()->json(['message' => 'Hanya customer yang dapat memberikan ulasan.'], 403);
        }

        $profile = ExpertProfile::where('user_id', $expert_id)->first();

        if (!$profile) {
            return response()->json(['message' => 'Profil ahli tidak ditemukan'], 404);
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string'
        ]);

        $review = Review::create([
            'expert_profile_id' => $profile->id,
            'user_id' => $user->id,
            'rating' => $request->rating,
            'comment' => $request->comment
        ]);

        return response()->json([
            'message' => 'Ulasan berhasil ditambahkan',
            'data' => $review
        ], 201);
    }
}
