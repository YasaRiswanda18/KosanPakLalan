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
        Schema::create('tagihans', function (Blueprint $table) {
            $table->id();
            
            // Sambungkan ke tabel penghuni (Penghuni ID)
            $table->foreignId('penghuni_id')->constrained('penghunis')->cascadeOnDelete();
            
            $table->string('bulan_tagihan'); // Contoh: "Agustus 2026"
            $table->integer('jumlah_bayar');
            $table->enum('status', ['Lunas', 'Belum Lunas'])->default('Belum Lunas');
            $table->date('tanggal_bayar')->nullable(); // Kosong kalau belum bayar
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tagihans');
    }
};