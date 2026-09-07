<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Pastikan kode bawaan "Test User" sudah terhapus, sisakan kode di bawah ini saja:

        // 1. Bikin Akun Khusus Admin (Pak Lalan)
        User::create([
            'name' => 'Pak Lalan',
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // 2. Bikin Akun Khusus Penghuni (Yasa)
        // 2. Bikin Akun Khusus Penghuni (Yasa)
        User::create([
            'name' => 'Yasa',
            'username' => 'yasa', // <-- Diubah jadi yasa aja
            'nomor_kamar' => 'Kamar 01 (VIP)', 
            'password' => Hash::make('password123'),
            'role' => 'penghuni',
        ]);
    }
}