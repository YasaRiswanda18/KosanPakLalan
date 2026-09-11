<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penghuni;
use App\Models\Kamar;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PenghuniController extends Controller
{
    public function index()
    {
        // PERBAIKAN 1: 'kamar' diganti jadi 'kamars'
        $penghunis = Penghuni::with('kamars')->latest()->get();
        $totalPenghuni = Penghuni::count();
        $kamarKosong = \App\Models\Kamar::where('status', 'Kosong')->get();

        return view('admin.penghuni.index', compact('penghunis', 'totalPenghuni', 'kamarKosong'));
    }

    // ==========================================
    // FUNGSI SIMPAN DATA PENGHUNI BARU
    // ==========================================
    public function store(Request $request)
    {
        $request->validate([
            'nik'           => 'required|numeric|digits:16|unique:penghunis,nik',
            'nama'          => 'required|string|max:255',
            'nomor_hp'      => 'required|string|min:10|max:13',
            'pekerjaan'     => 'required|string',
            'tanggal_masuk' => 'required|date',
            'kamar_id'      => 'required|exists:kamars,id',
        ], [
            'nik.unique'   => 'Gagal! NIK ini sudah terdaftar di sistem (Data Ganda).',
            'nik.digits'   => 'Format NIK salah! Harus pas 16 angka.',
            'nik.numeric'  => 'NIK hanya boleh berisi angka!',
            'nomor_hp.min' => 'Nomor WhatsApp minimal harus 10 digit!',
            'nomor_hp.max' => 'Nomor WhatsApp maksimal 13 digit!',
        ]);

        $namaBersih = strtolower(str_replace(' ', '', $request->nama));
        $usernameBaru = $namaBersih . rand(10, 99); 
        $passwordDefault = 'kos123';

        // Bikin Akun Login
        $user = User::create([
            'name'     => $request->nama,
            'username' => $usernameBaru,
            'password' => Hash::make($passwordDefault),
            'role'     => 'penghuni',
        ]);

        // PERBAIKAN 2: Simpan Penghuni (Hapus kamar_id karena udah nggak ada di tabel)
        $penghuniBaru = Penghuni::create([
            'user_id'       => $user->id,
            'nik'           => $request->nik,
            'nama'          => $request->nama,
            'nomor_hp'      => $request->nomor_hp,
            'pekerjaan'     => $request->pekerjaan,
            'tanggal_masuk' => $request->tanggal_masuk,
            'status'        => 'Aktif',
        ]);

        // PERBAIKAN 3: Assign Kamar ke Penghuni yang baru dibuat
        $kamar = \App\Models\Kamar::find($request->kamar_id);
        if ($kamar) {
            $kamar->update([
                'status'             => 'Terisi',
                'penghuni_id'        => $penghuniBaru->id,
                'nama_penghuni_asli' => $penghuniBaru->nama // Defaultnya nama penyewa utama
            ]);
        }

        return redirect()->back()->with('success_akun', 'Username: ' . $usernameBaru . ' | Password: ' . $passwordDefault);
    }

    // ==========================================
    // FUNGSI UPDATE / EDIT DATA PENGHUNI
    // ==========================================
    public function update(Request $request, $id)
    {
        $penghuni = Penghuni::with('kamars')->findOrFail($id);
        
        $request->validate([
            'nik'           => 'required|numeric|digits:16|unique:penghunis,nik,' . $id, 
            'nama'          => 'required|string|max:255',
            'nomor_hp'      => 'required|string|min:10|max:13',
            'pekerjaan'     => 'required|string',
        ], [
            'nik.unique'   => 'Gagal! NIK ini sudah dipakai penghuni lain.',
            'nik.digits'   => 'Format NIK salah! Harus pas 16 angka.',
            'nik.numeric'  => 'NIK hanya boleh berisi angka!',
        ]);

        // PERBAIKAN 4: Pindah Kamar Logic disesuaikan dengan relasi One-to-Many
        if ($request->filled('kamar_id')) {
            $kamar_id_baru = $request->kamar_id;
            
            // Cek apakah dia mau ganti kamar utama (ambil kamar pertama yang dia punya)
            $kamarLama = $penghuni->kamars->first(); 

            if (!$kamarLama || $kamarLama->id != $kamar_id_baru) {
                // Kosongkan kamar lama
                if ($kamarLama) {
                    $kamarLama->update([
                        'status'             => 'Kosong',
                        'penghuni_id'        => null,
                        'nama_penghuni_asli' => null
                    ]);
                }
                
                // Isi kamar baru
                $kamarBaru = Kamar::find($kamar_id_baru);
                if ($kamarBaru) {
                    $kamarBaru->update([
                        'status'             => 'Terisi',
                        'penghuni_id'        => $penghuni->id,
                        'nama_penghuni_asli' => $request->nama
                    ]);
                }
            }
        }

        // UPDATE DATA PENGHUNI
        $penghuni->update([
            'nik'       => $request->nik,
            'nama'      => $request->nama,
            'nomor_hp'  => $request->nomor_hp,
            'pekerjaan' => $request->pekerjaan,
        ]);

        // 👇 PERBAIKAN SINKRONISASI AKUN 
        if ($penghuni->user) {
            $penghuni->user->update([
                'name' => $request->nama
            ]);
        }
        // 👆 ======================================================= 👆

        return redirect()->route('admin.penghuni.index')->with('success', 'Mantap! Data penghuni berhasil diperbarui.');
    }

    // ==========================================
    // FUNGSI HAPUS PERMANEN
    // ==========================================
    public function destroy($id)
    {
        $penghuni = Penghuni::findOrFail($id);

        // PERBAIKAN 5: Kosongkan SEMUA kamar yang ditinggalkan (karena sekarang bisa banyak kamar)
        if ($penghuni->kamars()->count() > 0) {
            $penghuni->kamars()->update([
                'status'             => 'Kosong',
                'penghuni_id'        => null,
                'nama_penghuni_asli' => null,
                'kekerabatan'        => null
            ]);
        }

        // Hapus akun login-nya sekalian biar ngga nyampah di database
        if ($penghuni->user_id) {
            User::where('id', $penghuni->user_id)->delete();
        }

        // Hapus permanen data penghuni!
        $penghuni->delete();

        return redirect()->back()->with('success', 'Data Penghuni berhasil dihapus permanen! Seluruh kamar miliknya sekarang berstatus Kosong.');
    }

    // ==========================================
    // FUNGSI TAMBAH KAMAR SEWAAN (MULTI-KAMAR)
    // ==========================================
    public function tambahKamarSewa(Request $request, $id)
    {
        $request->validate([
            'kamar_id'           => 'required|exists:kamars,id',
            'nama_penghuni_asli' => 'required|string|max:255',
            'kekerabatan'        => 'required|string|max:255',
        ]);

        $penghuni = Penghuni::findOrFail($id);
        
        // Cari kamar yang dipilih, pastikan statusnya masih Kosong
        $kamar = Kamar::where('id', $request->kamar_id)->where('status', 'Kosong')->first();

        if (!$kamar) {
            return redirect()->back()->withErrors(['Gagal! Kamar yang dipilih sudah terisi atau tidak ditemukan.']);
        }

        // Assign kamar ini ke NIK Penghuni Utama (Yasa), tapi catat nama yang nempatin (Anton)
        $kamar->update([
            'status'             => 'Terisi',
            'penghuni_id'        => $penghuni->id,
            'nama_penghuni_asli' => $request->nama_penghuni_asli,
            'kekerabatan'        => $request->kekerabatan,
        ]);

        return redirect()->back()->with('success', 'Wushh! Kamar ' . $kamar->nomor_kamar . ' berhasil disewakan kepada ' . $request->nama_penghuni_asli . ' (Tanggungan: ' . $penghuni->nama . ').');
    }
    
    // ==========================================
    // FUNGSI UPDATE NAMA PENGHUNI SPESIFIK DI 1 KAMAR
    // ==========================================
    public function updateKamarSewa(Request $request, $kamar_id)
    {
        $request->validate([
            'nama_penghuni_asli' => 'required|string|max:255',
            'kekerabatan'        => 'required|string|max:255',
        ]);

        $kamar = \App\Models\Kamar::findOrFail($kamar_id);
        
        $kamar->update([
            'nama_penghuni_asli' => $request->nama_penghuni_asli,
            'kekerabatan'        => $request->kekerabatan,
        ]);

        return redirect()->back()->with('success', 'Sip! Data penghuni ' . $kamar->nomor_kamar . ' berhasil diperbarui.');
    }

    // ==========================================
    // FUNGSI LEPAS/KOSONGKAN 1 KAMAR SAJA
    // ==========================================
    public function hapusKamarSewa($kamar_id)
    {
        $kamar = \App\Models\Kamar::findOrFail($kamar_id);
        $nomor = $kamar->nomor_kamar;
        
        $kamar->update([
            'status'             => 'Kosong',
            'penghuni_id'        => null,
            'nama_penghuni_asli' => null,
            'kekerabatan'        => null,
        ]);

        return redirect()->back()->with('success', 'Beres! ' . $nomor . ' berhasil dilepas dari penyewa dan kembali berstatus Kosong.');
    }
}