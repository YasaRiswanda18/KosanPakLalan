<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use App\Models\Penghuni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengumumanController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $penghuni = Penghuni::with('kamars')->where('user_id', $user->id)->first();
        
        // 1. Ambil semua pengumuman aktif
        $pengumumans = Pengumuman::where('status', 'Aktif')
                                 ->orderBy('created_at', 'desc')
                                 ->paginate(6);

        // 2. TANDAI SEMUA SEBAGAI DIBACA (MARK AS READ)
        // Cari pengumuman aktif yang BELUM pernah dicatat di tabel pivot user ini
        $unreadPengumumans = Pengumuman::where('status', 'Aktif')->get();
        foreach ($unreadPengumumans as $p) {
            // syncWithoutDetaching artinya kalau belum ada, masukkan ke tabel pivot
            $user->pengumumans()->syncWithoutDetaching([
                $p->id => ['read_at' => now()]
            ]);
        }

        // 3. Hitung sisa notif belum dibaca (bakal jadi 0 pas halaman ini dibuka)
        $jumlahPengumuman = 0; 

        return view('user.pengumuman.index', compact('penghuni', 'pengumumans', 'jumlahPengumuman'));
    }
}