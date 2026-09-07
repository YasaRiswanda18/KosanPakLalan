<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Penghuni;
use App\Models\Tagihan;
use Carbon\Carbon;

class GenerateTagihanOtomatis extends Command
{
    // 1. NAMA PERINTAH TERMINAL (Password pemanggil robot)
    protected $signature = 'tagihan:generate';

    // 2. DESKRIPSI ROBOT
    protected $description = 'Generate tagihan kos otomatis setiap bulan berdasarkan tanggal masuk penghuni';

    // 3. OTAK ROBOTNYA (LOGIKA UTAMA)
    public function handle()
    {
        $this->info('Memulai pengecekan tagihan otomatis bulanan...');

        // Siapkan kalender bulan ini
        $bulanAngka = date('m'); 
        $bulanEng   = date('F'); 
        $bulanIndo  = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'][date('n') - 1];
        $tahunIni   = date('Y');

        $penghuniAktif = Penghuni::with('kamar')->where('status', 'Aktif')->whereNotNull('kamar_id')->get();
        $jumlahDibuat = 0;

        foreach ($penghuniAktif as $penghuni) {
            
            // Ekstrak hari dari tanggal masuk
            $hariMasuk = 1; 
            if ($penghuni->tanggal_masuk) {
                $hariMasuk = Carbon::parse($penghuni->tanggal_masuk)->format('d');
            }
            
            // Pengecekan limit kalender (Biar gak error di bulan yang cuma 30 hari)
            $maxHariBulanIni = Carbon::create($tahunIni, $bulanAngka, 1)->daysInMonth;
            $hariTagihanFinal = $hariMasuk > $maxHariBulanIni ? $maxHariBulanIni : $hariMasuk;
            
            // Format Simpan (Contoh: "19 August 2026")
            $formatSimpan = $hariTagihanFinal . ' ' . $bulanEng . ' ' . $tahunIni;

            // Satpam Pintar Anti-Dobel
            $tagihanAda = Tagihan::where('penghuni_id', $penghuni->id)
                ->where(function($q) use ($bulanIndo, $bulanEng) {
                    $q->where('bulan_tagihan', 'like', '%' . $bulanIndo . '%')
                      ->orWhere('bulan_tagihan', 'like', '%' . $bulanEng . '%');
                })
                ->where('bulan_tagihan', 'like', '%' . $tahunIni . '%') 
                ->exists();

            // Kalau tagihan belum ada, bikin baru!
            if (!$tagihanAda && $penghuni->kamar) {
                Tagihan::create([
                    'penghuni_id'   => $penghuni->id,
                    'bulan_tagihan' => $formatSimpan,
                    'jumlah_bayar'  => $penghuni->kamar->harga,
                    'status'        => 'Belum Lunas',
                    'tanggal_bayar' => null,
                ]);
                $jumlahDibuat++;
                
                // Laporan ke terminal biar kelihatan prosesnya
                $this->line("- Tagihan sukses dibuat untuk: " . $penghuni->nama . " (" . $formatSimpan . ")");
            }
        }

        // Kesimpulan eksekusi
        if ($jumlahDibuat > 0) {
            $this->info("Wushh! Robot berhasil membuat $jumlahDibuat tagihan otomatis!");
        } else {
            $this->info("Aman Bos! Semua penghuni sudah memiliki tagihan untuk bulan ini. Robot pamit tidur lagi.");
        }
    }
}