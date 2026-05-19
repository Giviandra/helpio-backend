<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['user_id', 'bio', 'location', 'verified_badge', 'current_status'])]
class ExpertProfile extends Model
{
    // Relasi: Profil ini milik satu user
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function workingHours(): HasMany
    {
        return $this->hasMany(WorkingHour::class);
    }
    // Membuat atribut buatan bernama 'real_time_status'
    public function getRealTimeStatusAttribute()
    {
        // 1. Dapatkan hari ini dalam bahasa Inggris (contoh: 'Tuesday') dan jam saat ini
        $now = Carbon::now();
        $today = $now->format('l'); 
        $currentTime = $now->format('H:i:s');

        // 2. Cari jadwal kerja ahli ini untuk hari ini
        $workingHour = $this->workingHours()->where('day_of_week', $today)->first();

        // 3. Jika hari ini libur, atau jadwal tidak ditemukan, paksa status jadi 'offline'
        if (!$workingHour || $workingHour->is_closed) {
            return 'offline';
        }

        // 4. Jika waktu saat ini berada di LUAR jam kerja, paksa status jadi 'offline'
        if ($currentTime < $workingHour->start_time || $currentTime > $workingHour->end_time) {
            return 'offline';
        }

        // 5. Jika masih dalam jam kerja, kembalikan status asli yang ada di database 
        // (bisa 'available' atau 'on_job' sesuai setelan si ahli)
        return $this->current_status;
    }
    
        // Pastikan atribut buatan ini selalu ikut dikirim saat API memanggil model ini
        protected $appends = ['real_time_status'];

    public function clickLogs(): HasMany
    {
    return $this->hasMany(ClickLog::class);
    }
}