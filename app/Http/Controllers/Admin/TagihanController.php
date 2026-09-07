<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tagihan;
use App\Models\Penghuni; 
use Carbon\Carbon;

class TagihanController extends Controller
{
    // =================================================================
    // HELPER TERPUSAT: Biar format teks periode selalu SAMA PERSIS 100%
    // =================================================================
    private function getPeriodeSekarang() {
        Carbon::setLocale('id');
        // Formatnya d F Y = (Tanggal Bulan Tahun)
        $tglMulai = Carbon::now()->translatedFormat('d F Y');
        $tglAkhir = Carbon::now()->addMonthsNoOverflow(1)->translatedFormat('d F Y');
        return $tglMulai . ' - ' . $tglAkhir;
    }

    // 1. Tampilkan Semua Data Tagihan
    public function index(Request $request)
    {
        $query = Tagihan::with(['penghuni.kamars'])->latest();

        // Filter Pencarian Nama
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('penghuni', function($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%');
            });
        }

        // Filter Bulan (Mesin Jaring 2 Bahasa)
        if ($request->filled('bulan') && $request->bulan != 'Semua Bulan') {
            $bulanIndo = $request->bulan;

            $kamusBulan = [
                'Januari' => 'January', 'Februari' => 'February', 'Maret' => 'March',
                'April' => 'April', 'Mei' => 'May', 'Juni' => 'June',
                'Juli' => 'July', 'Agustus' => 'August', 'September' => 'September',
                'Oktober' => 'October', 'November' => 'November', 'Desember' => 'December'
            ];
            $bulanInggris = $kamusBulan[$bulanIndo] ?? $bulanIndo;

            $query->where(function($q) use ($bulanIndo, $bulanInggris) {
                $q->where('bulan_tagihan', 'like', '%' . $bulanIndo . '%')
                  ->orWhere('bulan_tagihan', 'like', '%' . $bulanInggris . '%');
            });
        }

        $tagihans = $query->get();
        $totalPemasukan = $tagihans->where('status', 'Lunas')->sum('jumlah_bayar');
        $totalTunggakan = $tagihans->whereIn('status', ['Belum Lunas', 'Menunggu Konfirmasi'])->sum('jumlah_bayar');
        
        // 🛡️ FITUR SMART DROPDOWN 🛡️
        $periodeSekarang = $this->getPeriodeSekarang();

        // Tampilkan hanya Penghuni Aktif yang BELUM PUNYA TAGIHAN di periode ini
        $penghuniAktifList = Penghuni::with('kamars')
            ->whereDoesntHave('tagihans', function($q) use ($periodeSekarang) {
                $q->where('bulan_tagihan', $periodeSekarang);
            })->get(); 
        
        return view('admin.tagihan.index', compact('tagihans', 'totalPemasukan', 'totalTunggakan', 'penghuniAktifList'));
    }

    // 2. Fungsi Generate Tagihan Massal Otomatis
    public function generate(Request $request)
    {
        $periodeSekarang = $this->getPeriodeSekarang();
        $semuaPenghuni = Penghuni::with('kamars')->get();
        $jumlahDibuat = 0;

        foreach ($semuaPenghuni as $penghuni) {
            $totalBayar = $penghuni->kamars->sum('harga');

            if ($totalBayar > 0) {
                // Cek Anti-Double Tagihan
                $cekTagihan = Tagihan::where('penghuni_id', $penghuni->id)
                                     ->where('bulan_tagihan', $periodeSekarang)
                                     ->first();

                if (!$cekTagihan) {
                    Tagihan::create([
                        'penghuni_id'   => $penghuni->id,
                        'bulan_tagihan' => $periodeSekarang,
                        'jumlah_bayar'  => $totalBayar,
                        'status'        => 'Belum Lunas'
                    ]);
                    $jumlahDibuat++;
                }
            }
        }

        if ($jumlahDibuat == 0) {
            return redirect()->back()->with('error', "Semua penghuni aktif sudah memiliki tagihan untuk periode ini.");
        }

        return redirect()->back()->with('success', "Wushh! $jumlahDibuat tagihan baru untuk periode ini berhasil digenerate.");
    }

    // 3. Fungsi Buat Tagihan Manual (Per-orang)
    public function storeManual(Request $request)
    {
        $request->validate([
            'penghuni_id'   => 'required|exists:penghunis,id',
            'jumlah_bayar'  => 'required|numeric', 
            'bulan_tagihan' => 'required|string'
        ]);

        $periodeSekarang = $request->bulan_tagihan; // Ngambil dari input Form Blade
        $penghuniTerpilih = Penghuni::with('kamars')->findOrFail($request->penghuni_id);

        // Cek Anti-Double Tagihan
        $cekTagihan = Tagihan::where('penghuni_id', $penghuniTerpilih->id)
                             ->where('bulan_tagihan', $periodeSekarang)
                             ->first();

        if ($cekTagihan) {
            return redirect()->back()->with('error', 'Gagal! Penghuni atas nama ' . $penghuniTerpilih->nama . ' sudah memiliki tagihan di periode ini.');
        }

        Tagihan::create([
            'penghuni_id'   => $penghuniTerpilih->id,
            'bulan_tagihan' => $periodeSekarang,
            'jumlah_bayar'  => $request->jumlah_bayar,
            'status'        => 'Belum Lunas'
        ]);

        return redirect()->back()->with('success', 'Tagihan satuan atas nama ' . $penghuniTerpilih->nama . ' berhasil diterbitkan!');
    }

    // 4. Update (Edit Tagihan)
    public function update(Request $request, $id)
    {
        $tagihan = Tagihan::findOrFail($id);
        $tagihan->update([
            'jumlah_bayar' => $request->jumlah_bayar,
            'catatan' => $request->catatan,
        ]);
        return redirect()->back()->with('success', 'Data tagihan berhasil diperbarui.');
    }

    // 5. Destroy (Hapus Tagihan)
    public function destroy($id)
    {
        $tagihan = Tagihan::findOrFail($id);
        $tagihan->delete();
        return redirect()->back()->with('success', 'Tagihan berhasil dihapus dari sistem.');
    }

    // 6. Fungsi Backup / Cetak PDF
    public function cetakLaporan(Request $request)
    {
        $query = Tagihan::with(['penghuni.kamars'])->latest();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('penghuni', function($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('bulan') && $request->bulan != 'Semua Bulan') {
            $bulanIndo = $request->bulan;
            $kamusBulan = [
                'Januari' => 'January', 'Februari' => 'February', 'Maret' => 'March',
                'April' => 'April', 'Mei' => 'May', 'Juni' => 'June',
                'Juli' => 'July', 'Agustus' => 'August', 'September' => 'September',
                'Oktober' => 'October', 'November' => 'November', 'Desember' => 'December'
            ];
            $bulanInggris = $kamusBulan[$bulanIndo] ?? $bulanIndo;

            $query->where(function($q) use ($bulanIndo, $bulanInggris) {
                $q->where('bulan_tagihan', 'like', '%' . $bulanIndo . '%')
                  ->orWhere('bulan_tagihan', 'like', '%' . $bulanInggris . '%');
            });
        }

        $tagihans = $query->get();
        $totalPemasukan = $tagihans->where('status', 'Lunas')->sum('jumlah_bayar');

        return view('admin.tagihan.cetak', compact('tagihans', 'totalPemasukan'));
    }

    // 7. Fungsi Pak Lalan Konfirmasi Pembayaran
    public function konfirmasi($id)
    {
        $tagihan = Tagihan::findOrFail($id);
        $tagihan->update(['status' => 'Lunas']);
        return redirect()->back()->with('success', 'Sah! Pembayaran berhasil dikonfirmasi. Status tagihan otomatis menjadi Lunas.');
    }
    
    // 8. Fungsi Pak Lalan Tolak Pembayaran
    public function tolak(Request $request, $id)
    {
        $request->validate(['alasan_tolak' => 'required|string|max:255']);
        $tagihan = Tagihan::findOrFail($id);
        $tagihan->update([
            'status'       => 'Ditolak',
            'alasan_tolak' => $request->alasan_tolak,
            'bukti_bayar'  => null
        ]);
        return redirect()->back()->with('success', 'Pembayaran berhasil ditolak. Anak kos akan menerima notifikasi alasannya.');
    }

    // 9. Lunasin Manual/Cash
    public function bayar(Request $request, $id)
    {
        $tagihan = Tagihan::findOrFail($id);
        $tagihan->update(['status' => 'Lunas']);
        return redirect()->back()->with('success', 'Pembayaran tunai berhasil dikonfirmasi! Tagihan lunas.');
    }

    // 10. Fungsi Sapu Jagat
    public function bersihkanArsip(Request $request)
    {
        $query = Tagihan::where('status', 'Lunas');

        if ($request->filled('bulan') && $request->bulan != 'Semua Bulan') {
            $bulanIndo = $request->bulan;
            $kamusBulan = [
                'Januari' => 'January', 'Februari' => 'February', 'Maret' => 'March',
                'April' => 'April', 'Mei' => 'May', 'Juni' => 'June',
                'Juli' => 'July', 'Agustus' => 'August', 'September' => 'September',
                'Oktober' => 'October', 'November' => 'November', 'Desember' => 'December'
            ];
            $bulanInggris = $kamusBulan[$bulanIndo] ?? $bulanIndo;

            $query->where(function($q) use ($bulanIndo, $bulanInggris) {
                $q->where('bulan_tagihan', 'like', '%' . $bulanIndo . '%')
                  ->orWhere('bulan_tagihan', 'like', '%' . $bulanInggris . '%');
            });
        }

        $jumlahDihapus = $query->count();
        if ($jumlahDihapus == 0) {
            return redirect()->back()->with('error', 'Tidak ada data berstatus LUNAS pada filter bulan ini yang bisa dibersihkan.');
        }
        $query->delete();
        return redirect()->back()->with('success', "Beres Bos! $jumlahDihapus arsip tagihan Lunas berhasil dibersihkan permanen dari sistem.");
    }
    
    // 11. Fungsi Cetak Struk
    public function cetakStruk($id)
    {
        $tagihan = Tagihan::with(['penghuni.kamars'])->findOrFail($id);
        $terbilang = $this->penyebut($tagihan->jumlah_bayar) . ' Rupiah';

        return view('admin.tagihan.cetak_struk', compact('tagihan', 'terbilang'));
    }

    // Helper Rekursif Terbilang
    private function penyebut($nilai) {
        $nilai = abs($nilai);
        $huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
        $temp = "";
        if ($nilai < 12) {
            $temp = " " . $huruf[$nilai];
        } else if ($nilai < 20) {
            $temp = $this->penyebut($nilai - 10) . " Belas";
        } else if ($nilai < 100) {
            $temp = $this->penyebut($nilai / 10) . " Puluh" . $this->penyebut($nilai % 10);
        } else if ($nilai < 200) {
            $temp = " Seratus" . $this->penyebut($nilai - 100);
        } else if ($nilai < 1000) {
            $temp = $this->penyebut($nilai / 100) . " Ratus" . $this->penyebut($nilai % 100);
        } else if ($nilai < 2000) {
            $temp = " Seribu" . $this->penyebut($nilai - 1000);
        } else if ($nilai < 1000000) {
            $temp = $this->penyebut($nilai / 1000) . " Ribu" . $this->penyebut($nilai % 1000);
        } else if ($nilai < 1000000000) {
            $temp = $this->penyebut($nilai / 1000000) . " Juta" . $this->penyebut($nilai % 1000000);
        }
        return $temp;
    }
}