<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kamar extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_kamar', 
        'tipe_kamar', 
        'harga', 
        'status',
        'penghuni_id',        // ID Yasa (Penyewa Utama)
        'nama_penghuni_asli', // Nama Anton
        'kekerabatan'         // Saudara/Teman
    ];

    // Relasi balik ke tabel Penghuni (Kamar ini punya siapa?)
    public function penghuni()
    {
        return $this->belongsTo(Penghuni::class, 'penghuni_id');
    }
}