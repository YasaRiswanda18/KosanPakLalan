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
    Schema::table('penghunis', function (Blueprint $table) {
        // Nambahin kolom NIK, tipe string maksimal 16 karakter, dan WAJIB UNIQUE
        // after('nama_lengkap') ini bebas, biar posisinya rapi aja di sebelah kolom nama
        $table->string('nik', 16)->unique()->after('nama')->nullable();
    });
}

public function down()
{
    Schema::table('penghunis', function (Blueprint $table) {
        // Buat ngehapus kolom kalau sewaktu-waktu kita rollback
        $table->dropColumn('nik');
    });
}
};
