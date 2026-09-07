<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('pengumuman_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // PERBAIKAN DI SINI: Tentukan nama tabel aslinya secara eksplisit ('pengumuman')
            // Kalau di database lu ternyata namanya 'pengumumans', tinggal ganti jadi constrained('pengumumans')
            $table->foreignId('pengumuman_id')->constrained('pengumumans')->onDelete('cascade');
            
            $table->timestamp('read_at')->nullable(); // Kapan dibaca
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengumuman_user');
    }
};