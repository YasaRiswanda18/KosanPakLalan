<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kamar;

class KamarController extends Controller
{
    // ==========================================
    // 1. TAMPILKAN HALAMAN MANAJEMEN KAMAR
    // ==========================================
    public function index()
    {
        // Ambil data kamar beserta data penghuninya
        $kamars = Kamar::with('penghuni')->get();
        
        // Hitung statistik untuk Dashboard Atas
        $totalKamar = Kamar::count();
        $kamarTerisi = Kamar::where('status', 'Terisi')->count();
        $kamarKosong = Kamar::where('status', 'Kosong')->count();

        return view('admin.kamar.index', compact('kamars', 'totalKamar', 'kamarTerisi', 'kamarKosong'));
    }

    // ==========================================
    // 2. SIMPAN KAMAR BARU
    // ==========================================
    public function store(Request $request)
    {
        $request->validate([
            'nomor_kamar' => 'required|string|unique:kamars,nomor_kamar',
            'tipe_kamar'  => 'required|in:Standar,VIP',
            'harga'       => 'required|numeric|min:0',
        ], [
            'nomor_kamar.required' => 'Nomor kamar wajib diisi!',
            'nomor_kamar.unique'   => 'Nomor kamar ini sudah ada di sistem!',
            'harga.required'       => 'Harga sewa wajib diisi!',
        ]);

        Kamar::create([
            'nomor_kamar' => $request->nomor_kamar,
            'tipe_kamar'  => $request->tipe_kamar,
            'harga'       => $request->harga,
            'status'      => 'Kosong', // Default otomatis kosong
        ]);

        return redirect()->route('admin.kamar.index')->with('success', 'Mantap! Kamar baru berhasil ditambahkan.');
    }

    // ==========================================
    // 3. UPDATE DATA KAMAR (SATUAN)
    // ==========================================
    public function update(Request $request, $id)
    {
        $request->validate([
            'nomor_kamar' => 'required|string|unique:kamars,nomor_kamar,' . $id,
            'tipe_kamar'  => 'required|in:Standar,VIP',
            'harga'       => 'required|numeric|min:0',
            'status'      => 'required|in:Kosong,Terisi',
        ], [
            'nomor_kamar.required' => 'Nomor kamar wajib diisi!',
            'nomor_kamar.unique'   => 'Nomor kamar ini sudah ada di sistem!',
            'harga.required'       => 'Harga sewa wajib diisi!',
        ]);

        $kamar = Kamar::findOrFail($id);

        $kamar->update([
            'nomor_kamar' => $request->nomor_kamar,
            'tipe_kamar'  => $request->tipe_kamar,
            'harga'       => $request->harga,
            'status'      => $request->status,
        ]);

        return redirect()->route('admin.kamar.index')->with('success', 'Wushh! Data kamar berhasil diperbarui.');
    }

    // ==========================================
    // 4. HAPUS KAMAR
    // ==========================================
    public function destroy($id)
    {
        $kamar = Kamar::findOrFail($id);
        $kamar->delete();

        return redirect()->route('admin.kamar.index')->with('success', 'Data kamar berhasil dihapus selamanya dari sistem!');
    }

    // ==========================================
    // 5. UPDATE TARIF MASSAL BERDASARKAN TIPE
    // ==========================================
    public function updateTarifMassal(Request $request)
    {
        $request->validate([
            'tipe_kamar' => 'required|in:Standar,VIP',
            'harga_baru' => 'required|numeric|min:0',
        ]);

        // 1 Baris sakti buat update massal!
        Kamar::where('tipe_kamar', $request->tipe_kamar)->update(['harga' => $request->harga_baru]);

        return redirect()->route('admin.kamar.index')->with('success', 'Tarif Kamar ' . $request->tipe_kamar . ' berhasil diupdate massal menjadi Rp ' . number_format($request->harga_baru, 0, ',', '.') . '!');
    }
}