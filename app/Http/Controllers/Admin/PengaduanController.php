<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengaduan;

class PengaduanController extends Controller
{
    // 1. Tampilkan Semua Keluhan
    public function index()
    {
        // Ambil data pengaduan, sekalian bawa data penghuni dan kamarnya
        $pengaduans = Pengaduan::with(['penghuni.kamars'])->latest()->get();
        
        return view('admin.pengaduan.index', compact('pengaduans'));
    }

    // 2. Fungsi Pak Lalan Ubah Status (Menunggu -> Diproses -> Selesai)
    public function updateStatus(Request $request, $id)
    {
        $pengaduan = Pengaduan::findOrFail($id);
        
        $pengaduan->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Mantap! Status keluhan berhasil diubah menjadi: ' . $request->status);
    }
    public function destroy($id)
    {
        // Cari data keluhan berdasarkan ID
        $pengaduan = Pengaduan::findOrFail($id);
        
        // Eksekusi hapus data dari database
        $pengaduan->delete();

        // Kembalikan ke halaman sebelumnya dengan pesan sukses
        return redirect()->back()->with('success', 'Mantap Bos! Laporan berhasil dihapus.');
    }
}