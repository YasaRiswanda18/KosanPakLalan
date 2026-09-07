<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use Illuminate\Http\Request;
use App\Models\Kamar;
use App\Models\Penghuni;
use App\Models\Tagihan;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Ambil Data Kamar
        $totalKamar = Kamar::count();
        $kamarKosong = Kamar::where('status', 'Kosong')->count();
        $kamarTerisi = Kamar::where('status', 'Terisi')->count();

        // 2. Ambil Data Penghuni 
        $penghuniAktif = Penghuni::where('status', 'Aktif')->count();
        
        // PERBAIKAN: Ubah 'kamar' menjadi 'kamars' sesuai nama relasi baru di Model Penghuni
        $penghunisTerbaru = Penghuni::with('kamars')->latest()->take(4)->get();

        // 3. Ambil Data Keuangan (Total Keseluruhan Kas)
        $namaBulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $bulanIni = $namaBulan[date('n') - 1] . ' ' . date('Y'); 
        
        // Kita hitung SEMUA tagihan yang Lunas
        $pemasukan = Tagihan::where('status', 'Lunas')->sum('jumlah_bayar');

        // Ambil 3 pengaduan terbaru yang belum selesai
        $pengaduanTerbaru = Pengaduan::where('status', '!=', 'Selesai')
                                     ->latest()
                                     ->take(3)
                                     ->get();

        // 4. Kirim semua datanya ke tampilan
        return view('admin.dashboard', compact(
            'totalKamar', 'kamarKosong', 'kamarTerisi', 
            'penghuniAktif', 'pemasukan', 'bulanIni', 'penghunisTerbaru', 'pengaduanTerbaru'
        ));
    }
}