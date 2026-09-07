<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penghuni extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'nik',
        'nama',
        'nomor_hp',
        'pekerjaan',
        'tanggal_masuk',
        'status',
    ];
    // Catatan: 'kamar_id' udah dihapus dari fillable ya!

    // Relasi ke tabel User (Opsional kalau user bisa login)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke tabel Kamar (1 Penghuni -> Banyak Kamar)
    public function kamars()
    {
        return $this->hasMany(Kamar::class, 'penghuni_id');
    }

    // Relasi ke tabel Tagihan (1 Penghuni -> Banyak Tagihan)
    public function tagihans()
    {
        return $this->hasMany(Tagihan::class, 'penghuni_id');
    }
}