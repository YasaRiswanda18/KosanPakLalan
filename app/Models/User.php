<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// INI YANG BARU: Menambahkan 'email' ke dalam daftar Fillable agar tidak error
#[Fillable(['name', 'username', 'nomor_kamar', 'email', 'password', 'role'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            // 'email_verified_at' dihapus karena sudah tidak pakai email bawaan
            'password' => 'hashed',
        ];
    }

    public function pengumumans()
    {
        return $this->belongsToMany(Pengumuman::class, 'pengumuman_user')
                    ->withPivot('read_at')
                    ->withTimestamps();
    }
}