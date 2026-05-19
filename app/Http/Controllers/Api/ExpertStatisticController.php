<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ClickLog;
use App\Models\ExpertProfile;

class ExpertStatisticController extends Controller
{
    // 1. Mencatat Klik (Dipanggil oleh Frontend secara diam-diam)
    public function trackClick(Request $request, $expert_id)
    {
        $request->validate([
            'click_type' => 'required|in:whatsapp,profile_view'
        ]);

        $profile = ExpertProfile::where('user_id', $expert_id)->first();

        if (!$profile) {
            return response()->json(['message' => 'Profil ahli tidak ditemukan'], 404);
        }

        // Catat klik ke database
        ClickLog::create([
            'expert_profile_id' => $profile->id,
            'click_type' => $request->click_type,
            'ip_address' => $request->ip() // Mengambil IP dari user yang mengklik
        ]);

        return response()->json(['message' => 'Klik berhasil dicatat']);
    }

    // 2. Mengambil Statistik (Hanya untuk ahli yang login melihat dashboard mereka)
    public function getStats(Request $request)
    {
        $user = $request->user();

        if ($user->role !== 'expert') {
            return response()->json(['message' => 'Akses ditolak.'], 403);
        }

        $profile = $user->expertProfile;

        if (!$profile) {
            return response()->json(['message' => 'Profil belum lengkap.'], 400);
        }

        // Hitung total klik berdasarkan jenisnya
        $totalWhatsappClicks = $profile->clickLogs()->where('click_type', 'whatsapp')->count();
        $totalProfileViews = $profile->clickLogs()->where('click_type', 'profile_view')->count();

        return response()->json([
            'message' => 'Berhasil mengambil statistik',
            'data' => [
                'total_whatsapp_clicks' => $totalWhatsappClicks,
                'total_profile_views' => $totalProfileViews,
                'total_interactions' => $totalWhatsappClicks + $totalProfileViews
            ]
        ]);
    }
}
