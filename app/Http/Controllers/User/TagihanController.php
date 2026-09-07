<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Penghuni;
use App\Models\Tagihan; // Pastikan model Tagihan dipanggil

class TagihanController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Cari data penghuni yang cocok dengan user login
        $penghuni = Penghuni::where('user_id', $user->id)->first();

        // Ambil riwayat tagihan khusus untuk penghuni ini
        $tagihans = [];
        if ($penghuni) {
            // Asumsi di tabel tagihans ada kolom 'penghuni_id'
            $tagihans = Tagihan::where('penghuni_id', $penghuni->id)
                               ->latest() // Urutkan dari yang terbaru
                               ->get();
        }

        return view('user.tagihan.index', compact('penghuni', 'tagihans'));
    }

    // Fungsi untuk memproses upload bukti bayar
    public function uploadBukti(Request $request, $id)
    {
        $request->validate([
            'bukti_bayar' => 'required|image|mimes:jpeg,png,jpg|max:2048' // Maksimal 2MB
        ]);

        $tagihan = Tagihan::findOrFail($id);

        if ($request->hasFile('bukti_bayar')) {
            // Simpan foto ke folder storage/app/public/bukti_pembayaran
            $fotoPath = $request->file('bukti_bayar')->store('bukti_pembayaran', 'public');
            
            // Update tagihan: simpan path foto dan ubah status
            $tagihan->update([
                'bukti_bayar' => $fotoPath,
                'status'      => 'Menunggu Konfirmasi'
            ]);
        }

        return redirect()->back()->with('success', 'Bukti pembayaran berhasil dikirim! Silakan tunggu konfirmasi dari Pak Lalan.');
    }
}