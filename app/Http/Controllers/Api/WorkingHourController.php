<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WorkingHour;

class WorkingHourController extends Controller
{
    public function updateSchedule(Request $request)
    {
        $user = $request->user();

        // Validasi: Hanya expert yang bisa mengatur jadwal kerja
        if ($user->role !== 'expert') {
            return response()->json(['message' => 'Akses ditolak.'], 403);
        }

        $profile = $user->expertProfile;

        // Pastikan expert sudah mengisi profilnya terlebih dahulu
        if (!$profile) {
            return response()->json(['message' => 'Silakan lengkapi profil ahli Anda terlebih dahulu.'], 400);
        }

        // Validasi input jadwal (harus berupa array berisi hari dan jam)
        $request->validate([
            'schedules' => 'required|array',
            'schedules.*.day_of_week' => 'required|string|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'schedules.*.start_time' => 'nullable|date_format:H:i', // Format jam, misal "08:00"
            'schedules.*.end_time' => 'nullable|date_format:H:i',
            'schedules.*.is_closed' => 'required|boolean',
        ]);

        // Looping data jadwal yang dikirim FE, lalu simpan ke database
        foreach ($request->schedules as $schedule) {
            WorkingHour::updateOrCreate(
                [
                    'expert_profile_id' => $profile->id,
                    'day_of_week' => $schedule['day_of_week']
                ],
                [
                    'start_time' => $schedule['start_time'] ?? null,
                    'end_time' => $schedule['end_time'] ?? null,
                    'is_closed' => $schedule['is_closed']
                ]
            );
        }

        return response()->json([
            'message' => 'Jadwal kerja berhasil diperbarui',
            // Kembalikan data jadwal yang baru saja diupdate
            'data' => $profile->workingHours 
        ]);
    }
}
