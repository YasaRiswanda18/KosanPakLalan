<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Penghuni;
use App\Models\Pengumuman;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Cari data penghuni yang cocok dengan user_id yang sedang login
        $penghuni = Penghuni::with('kamars')->where('user_id', $user->id)->first();

        // Tarik data pengumuman aktif untuk ditampilkan di beranda
        $pengumumans = Pengumuman::where('status', 'Aktif')
                                 ->orderBy('created_at', 'desc')
                                 ->get();

        // Hitung berapa pengumuman aktif yang belum dibaca oleh user ini
        $jumlahPengumuman = Pengumuman::where('status', 'Aktif')
            ->whereDoesntHave('users', function($q) use ($user) {
                $q->where('user_id', $user->id)->whereNotNull('read_at');
            })->count();

        return view('user.dashboard.index', compact('penghuni', 'pengumumans', 'jumlahPengumuman'));
    }

    // Halaman khusus lihat semua pengumuman untuk user
    public function pengumumanIndex()
    {
        $user = Auth::user();
        $penghuni = Penghuni::with('kamars')->where('user_id', $user->id)->first();

        // 1. Ambil semua pengumuman aktif (pakai paginate sesuai fitur kita sebelumnya)
        $pengumumans = Pengumuman::where('status', 'Aktif')
                                 ->orderBy('created_at', 'desc')
                                 ->paginate(6);

        // 2. TANDAI SEMUA SEBAGAI DIBACA (MARK AS READ)
        // Begitu user buka halaman ini, masukkan semua pengumuman aktif ke tabel pivot read_at
        $unreadPengumumans = Pengumuman::where('status', 'Aktif')->get();
        foreach ($unreadPengumumans as $p) {
            $user->pengumumans()->syncWithoutDetaching([
                $p->id => ['read_at' => now()]
            ]);
        }

        // 3. Karena sudah dibaca, sisa notif otomatis jadi 0
        $jumlahPengumuman = 0;

        return view('user.pengumuman.index', compact('penghuni', 'pengumumans', 'jumlahPengumuman'));
    }
}