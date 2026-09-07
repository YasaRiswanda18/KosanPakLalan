<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Penghuni;
use App\Models\Pengaduan;
use app\Models\Pengumuman;
use Illuminate\Support\Facades\Storage;


class PengaduanController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $penghuni = Penghuni::where('user_id', $user->id)->first();
        
        // Ambil riwayat laporan keluhan anak kos ini
        $pengaduans = Pengaduan::where('penghuni_id', $penghuni->id)->latest()->get();

        return view('user.pengaduan.index', compact('penghuni', 'pengaduans'));
    }

    public function store(Request $request)
    {
        // Tambahkan validasi untuk file foto
        $request->validate([
            'judul'     => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'foto'      => 'nullable|image|mimes:jpeg,png,jpg|max:2048' // Maksimal 2MB
        ]);

        $user = Auth::user();
        $penghuni = Penghuni::where('user_id', $user->id)->first();

        // Proses Upload Foto (Kalau anak kos masukin foto)
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            // Simpan foto ke folder storage/app/public/pengaduans
            $fotoPath = $request->file('foto')->store('pengaduans', 'public');
        }

        // Simpan semua data ke database
        Pengaduan::create([
            'penghuni_id' => $penghuni->id,
            'judul'       => $request->judul,
            'deskripsi'   => $request->deskripsi,
            'foto'        => $fotoPath, // <--- Masukin nama path fotonya ke DB
            'status'      => 'Menunggu'
        ]);

        return redirect()->back()->with('success', 'Mantap! Keluhan dan bukti foto berhasil dikirim ke Pak Lalan.');
    }
    public function destroy($id)
    {
        $user = Auth::user();
        $penghuni = Penghuni::where('user_id', $user->id)->first();

        // Cari data keluhan berdasarkan ID
        // PENTING: Tambahin where('penghuni_id') biar anak kos gak bisa iseng ngapus keluhan orang lain!
        $pengaduan = Pengaduan::where('id', $id)
                              ->where('penghuni_id', $penghuni->id)
                              ->firstOrFail();

        // Hapus file foto dari folder storage (kalau ada fotonya)
        if ($pengaduan->foto) {
            // Kita bersihin kata 'public/' kalau nyangkut di DB
            $pathFoto = str_replace('public/', '', $pengaduan->foto);
            
            // Cek apakah file fisik fotonya beneran ada, kalau ada langsung basmi
            if (Storage::disk('public')->exists($pathFoto)) {
                Storage::disk('public')->delete($pathFoto);
            }
        }

        // Musnahkan data dari database
        $pengaduan->delete();

        // Balikin user ke halaman tadi beserta pesan sukses
        return redirect()->back()->with('success', 'Mantap! Laporan keluhan berhasil dihapus dari riwayat.');
    }
}