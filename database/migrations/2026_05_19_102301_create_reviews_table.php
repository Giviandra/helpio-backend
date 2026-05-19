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
    Schema::create('reviews', function (Blueprint $table) {
        $table->id();
        
        // Relasi ke tabel profil ahli (siapa yang dinilai)
        $table->foreignId('expert_profile_id')->constrained('expert_profiles')->cascadeOnDelete();
        
        // Relasi ke tabel users (siapa customer yang menilai)
        $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
        
        // Rating 1 sampai 5
        $table->tinyInteger('rating'); 
        
        // Komentar ulasan (bisa kosong)
        $table->text('comment')->nullable();
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
