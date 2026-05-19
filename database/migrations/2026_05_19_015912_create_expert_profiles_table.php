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
    Schema::create('expert_profiles', function (Blueprint $table) {
        $table->id();
        // Relasi ke tabel users
        $table->foreignId('user_id')->constrained('users')->cascadeOnDelete(); 
        
        $table->text('bio')->nullable();
        $table->string('location')->nullable();
        
        // Fitur Kurasi & Kepercayaan: Badge Terverifikasi
        $table->boolean('verified_badge')->default(false); 
        
        // Persiapan untuk fitur "Status Ketersediaan Real-Time" nanti
        $table->enum('current_status', ['available', 'on_job', 'offline'])->default('offline');
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expert_profiles');
    }
};
