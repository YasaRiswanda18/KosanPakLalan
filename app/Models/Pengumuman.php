<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    use HasFactory;

    protected $table = 'pengumumans';

    protected $fillable = [
        'judul',
        'isi_pengumuman',
        'kategori',
        'status'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'pengumuman_user')
                    ->withPivot('read_at')
                    ->withTimestamps();
    }
}