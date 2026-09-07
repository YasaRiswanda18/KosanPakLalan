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
        Schema::create('penghunis', function (Blueprint $table) {
            $table->id();
            // Sambungkan ke tabel kamar (Kamar ID)
            
            $table->string('nama');
            $table->string('nomor_hp');
            $table->enum('pekerjaan', ['Mahasiswa', 'Karyawan', 'Lainnya']);
            $table->date('tanggal_masuk');
            $table->enum('status', ['Aktif', 'Keluar'])->default('Aktif');
            $table->timestamps();
        });
    }
};
