<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('working_hours', function (Blueprint $table) {
        $table->id();
        // Relasi ke tabel profil ahli
        $table->foreignId('expert_profile_id')->constrained('expert_profiles')->cascadeOnDelete();
        
        $table->string('day_of_week'); // Contoh: 'Monday', 'Tuesday'
        $table->time('start_time')->nullable(); // Jam buka, misal '08:00:00'
        $table->time('end_time')->nullable();   // Jam tutup, misal '17:00:00'
        $table->boolean('is_closed')->default(false); // Jika true, berarti hari itu libur
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('working_hours');
    }
};
