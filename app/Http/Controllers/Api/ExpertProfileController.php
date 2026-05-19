<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ExpertProfile;
use App\Models\User;

class ExpertProfileController extends Controller
{
    // 1. Mengambil daftar semua ahli jasa (Untuk halaman utama FE)
    public function index()
    {
        // Ambil data dari tabel users yang rolenya 'expert', beserta relasi profilnya
        $experts = User::where('role', 'expert')->with('expertProfile')->get();

        return response()->json([
            'message' => 'Berhasil mengambil daftar ahli jasa',
            'data' => $experts
        ]);
    }

    // 2. Melihat detail satu ahli tertentu (Untuk halaman profil ahli di FE)
    public function show($id)
    {
        $expert = User::where('role', 'expert')->with('expertProfile')->find($id);

        if (!$expert) {
            return response()->json(['message' => 'Ahli jasa tidak ditemukan'], 404);
        }

        return response()->json([
            'message' => 'Detail profil ahli',
            'data' => $expert
        ]);
    }

    // 3. Membuat atau Memperbarui Profil (Khusus untuk expert yang sedang login)
    public function updateProfile(Request $request)
    {
        // Ambil data user yang sedang login (berdasarkan token Sanctum)
        $user = $request->user();

        // Validasi: Pastikan yang mengakses ini benar-benar 'expert'
        if ($user->role !== 'expert') {
            return response()->json(['message' => 'Akses ditolak. Hanya ahli jasa yang bisa mengubah profil.'], 403);
        }

        $request->validate([
            'bio' => 'nullable|string',
            'location' => 'nullable|string',
            'current_status' => 'in:available,on_job,offline'
        ]);

        // Gunakan updateOrCreate:
        // Jika profil belum ada, Laravel akan membuatkannya.
        // Jika sudah ada, Laravel hanya akan mengupdatenya.
        $profile = ExpertProfile::updateOrCreate(
            ['user_id' => $user->id], // Cari berdasarkan user_id
            [
                'bio' => $request->bio,
                'location' => $request->location,
                'current_status' => $request->current_status ?? 'offline',
            ] // Data yang diupdate/dibuat
        );

        return response()->json([
            'message' => 'Profil ahli berhasil disimpan',
            'data' => $profile
        ]);
    }
}
