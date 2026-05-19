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
    Schema::create('click_logs', function (Blueprint $table) {
        $table->id();
        $table->foreignId('expert_profile_id')->constrained('expert_profiles')->cascadeOnDelete();
        
        // Jenis klik: 'whatsapp' atau 'profile_view'
        $table->string('click_type'); 
        
        // Menyimpan IP untuk mencegah spam klik dari orang yang sama dihitung berkali-kali (opsional)
        $table->ipAddress('ip_address')->nullable(); 
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('click_logs');
    }
};
