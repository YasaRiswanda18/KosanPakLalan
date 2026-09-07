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
        Schema::create('kamars', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_kamar')->unique();
            $table->string('tipe_kamar');            
            $table->integer('harga');                
            $table->enum('status', ['Kosong', 'Terisi'])->default('Kosong');
            
            // --- TAMBAHAN BARU BOSKU ---
            // Menyambungkan Kamar ke Penghuni Penanggung Jawab (Yasa)
            $table->foreignId('penghuni_id')->nullable()->constrained('penghunis')->onDelete('set null');
            // Menyimpan nama orang yang tidur di kamar (Anton)
            $table->string('nama_penghuni_asli')->nullable(); 
            // Hubungan dengan penanggung jawab (Saudara/Teman)
            $table->string('kekerabatan')->nullable();
            // ---------------------------

            $table->timestamps();
        });
    }
};

