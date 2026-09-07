<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PenghuniController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\TagihanController as UserTagihanController;
use App\Http\Controllers\User\ProfileController as UserProfileController;
use App\Http\Controllers\User\PengaduanController as UserPengaduanController;
use App\Http\Controllers\Admin\PengaduanController as AdminPengaduanController;
use App\Http\Controllers\Admin\TagihanController as AdminTagihanController;
use App\Http\Controllers\Admin\AkunController as AdminAkunController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\User\PengumumanController as UserPengumumanController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// --- TAMBAHAN KITA KEMARIN ---

// Rute khusus Admin (dijaga satpam 'role:admin')
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
});

// Rute khusus Penghuni (dijaga satpam 'role:penghuni')
Route::middleware(['auth', 'role:penghuni'])->group(function () {
    Route::get('/penghuni/dashboard', [PenghuniController::class, 'index'])->name('penghuni.dashboard');
});
// RUTE BARU (Wajib mampir ke Controller)
Route::get('/admin/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('admin.dashboard');
// Rute untuk Halaman Manajemen Kamar
Route::get('/admin/kamar', [App\Http\Controllers\KamarController::class, 'index'])->middleware(['auth'])->name('admin.kamar.index');
// Rute untuk Halaman Manajemen Kamar
Route::get('/admin/kamar', [App\Http\Controllers\KamarController::class, 'index'])->middleware(['auth'])->name('admin.kamar.index');

Route::put('/admin/kamar/update-tarif', [App\Http\Controllers\KamarController::class, 'updateTarifMassal'])->name('admin.kamar.updateTarifMassal');
// Rute untuk PROSES Tambah Kamar Baru (BARU)
Route::post('/admin/kamar', [App\Http\Controllers\KamarController::class, 'store'])->middleware(['auth'])->name('admin.kamar.store');
// Rute untuk PROSES Update/Edit Kamar
Route::put('/admin/kamar/{id}', [App\Http\Controllers\KamarController::class, 'update'])->middleware(['auth'])->name('admin.kamar.update');
// Rute untuk PROSES Hapus Kamar
Route::delete('/admin/kamar/{id}', [App\Http\Controllers\KamarController::class, 'destroy'])->middleware(['auth'])->name('admin.kamar.destroy');
// Rute untuk Halaman Manajemen Penghuni
Route::get('/admin/penghuni', [App\Http\Controllers\PenghuniController::class, 'index'])->middleware(['auth'])->name('admin.penghuni.index');
// Rute untuk PROSES Tambah Penghuni Baru
Route::post('/admin/penghuni', [App\Http\Controllers\PenghuniController::class, 'store'])->middleware(['auth'])->name('admin.penghuni.store');




// Rute untuk Update (Edit) dan Delete (Hapus) Data Penghuni
Route::put('/admin/penghuni/{id}', [App\Http\Controllers\PenghuniController::class, 'update'])->middleware(['auth']);
Route::delete('/admin/penghuni/{id}', [App\Http\Controllers\PenghuniController::class, 'destroy'])->middleware(['auth']);
// Rute untuk Halaman Manajemen Tagihan & Kas
Route::get('/admin/tagihan', [App\Http\Controllers\TagihanController::class, 'index'])->middleware(['auth'])->name('admin.tagihan.index');
// Rute untuk Proses Konfirmasi Pembayaran
Route::post('/admin/tagihan/{id}/bayar', [App\Http\Controllers\TagihanController::class, 'bayar'])->middleware(['auth'])->name('admin.tagihan.bayar');
// Rute untuk Generate Tagihan Massal Bulan Ini
Route::post('/admin/tagihan/generate', [App\Http\Controllers\TagihanController::class, 'generate'])->middleware(['auth'])->name('admin.tagihan.generate');

// Rute untuk reset riwayat penghuni keluar
Route::post('/admin/penghuni/clear-keluar', [App\Http\Controllers\PenghuniController::class, 'clearKeluar'])->name('admin.penghuni.clearKeluar');
// Rute untuk bikin tagihan satuan/manual
Route::post('/admin/tagihan/store-manual', [App\Http\Controllers\TagihanController::class, 'storeManual'])->name('admin.tagihan.storeManual');
// Rute untuk Edit dan Hapus Tagihan
Route::put('/admin/tagihan/{id}', [App\Http\Controllers\TagihanController::class, 'update'])->name('admin.tagihan.update');
Route::delete('/admin/tagihan/{id}', [App\Http\Controllers\TagihanController::class, 'destroy'])->name('admin.tagihan.destroy');
// --- PASTIKAN BARIS INI TIDAK TERHAPUS KARENA INI JANTUNGNYA HALAMAN LOGIN ---
require __DIR__.'/auth.php';



// ==========================================
// ROUTE KHUSUS ANAK KOS (USER)
// ==========================================
Route::prefix('user')->middleware(['auth'])->group(function () {
    
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
    Route::get('/pengumuman', [UserPengumumanController::class, 'index'])->name('user.pengumuman');
    Route::get('/tagihan', [UserTagihanController::class, 'index'])->name('user.tagihan');
    Route::put('/tagihan/{id}/upload-bukti', [UserTagihanController::class, 'uploadBukti'])->name('user.tagihan.upload');
    
    // Halaman Profil & Keamanan
    Route::get('/profil', [UserProfileController::class, 'index'])->name('user.profile');
    Route::put('/profil/update', [UserProfileController::class, 'update'])->name('user.profile.update'); 

    // Halaman Pengaduan / Keluhan
    Route::get('/pengaduan', [UserPengaduanController::class, 'index'])->name('user.pengaduan'); 
    Route::post('/pengaduan', [UserPengaduanController::class, 'store'])->name('user.pengaduan.store');
    
    Route::delete('/pengaduan/{id}', [UserPengaduanController::class, 'destroy'])->name('user.pengaduan.destroy');
    
});

// ==========================================
// ROUTE KHUSUS ADMIN
// ==========================================
// Pastikan kode di bawah ini ada di dalam grup middleware admin !
Route::prefix('admin')->middleware(['auth'])->group(function () {

   Route::get('/pengumuman', [PengumumanController::class, 'index'])->name('admin.pengumuman.index');
    Route::post('/pengumuman', [PengumumanController::class, 'store'])->name('admin.pengumuman.store');
    Route::put('/pengumuman/{id}', [PengumumanController::class, 'update'])->name('admin.pengumuman.update');
    Route::delete('/pengumuman/{id}', [PengumumanController::class, 'destroy'])->name('admin.pengumuman.destroy');
    
    // Halaman Keluhan & Pengaduan
    Route::get('/pengaduan', [AdminPengaduanController::class, 'index'])->name('admin.pengaduan.index');
    Route::put('/pengaduan/{id}/status', [AdminPengaduanController::class, 'updateStatus'])->name('admin.pengaduan.updateStatus');
    Route::delete('/pengaduan/{id}', [AdminPengaduanController::class, 'destroy'])->name('admin.pengaduan.destroy');
  

     // RUTE SAPU JAGAT ARSIP LUNAS
    Route::delete('/hapus-arsip-tagihan-massal', [AdminTagihanController::class, 'bersihkanArsip'])->name('admin.tagihan.bersihkan');

    // Halaman Tagihan & Kas Admin
    Route::get('/tagihan', [AdminTagihanController::class, 'index'])->name('admin.tagihan.index');
    Route::put('/tagihan/{id}/konfirmasi', [AdminTagihanController::class, 'konfirmasi'])->name('admin.tagihan.konfirmasi');
    Route::get('/tagihan/cetak-struk/{id}', [AdminTagihanController::class, 'cetakStruk'])->name('admin.tagihan.cetak_struk');

    // RUTE BARU CETAK LAPORAN 
    Route::get('/tagihan/cetak', [AdminTagihanController::class, 'cetakLaporan'])->name('admin.tagihan.cetak');
    
    // Rute Baru Buat Tolak Bukti
    Route::put('/tagihan/{id}/tolak', [AdminTagihanController::class, 'tolak'])->name('admin.tagihan.tolak');

    // Halaman Kelola Akun User & Reset Password
    Route::get('/akun', [AdminAkunController::class, 'index'])->name('admin.akun.index');
    Route::put('/akun/{id}/reset-password', [AdminAkunController::class, 'resetPassword'])->name('admin.akun.reset');
    Route::delete('/akun/{id}', [AdminAkunController::class, 'destroy'])->name('admin.akun.destroy');

    // Halaman Profil Admin
    Route::get('/profil', [App\Http\Controllers\Admin\ProfilController::class, 'index'])->name('admin.profil.index');
    Route::put('/profil/update', [App\Http\Controllers\Admin\ProfilController::class, 'update'])->name('admin.profil.update');

    // Route untuk Proses Nambah Kamar Extra (Buat Saudara/Teman)
    Route::post('/penghuni/{id}/tambah-kamar', [App\Http\Controllers\PenghuniController::class, 'tambahKamarSewa'])->name('admin.penghuni.tambahKamar');

    // Route untuk Edit & Lepas Kamar Spesifik (Multi-Kamar)
    Route::put('/penghuni/kamar/{kamar_id}', [App\Http\Controllers\PenghuniController::class, 'updateKamarSewa'])->name('admin.penghuni.updateKamarSewa');
    Route::delete('/penghuni/kamar/{kamar_id}', [App\Http\Controllers\PenghuniController::class, 'hapusKamarSewa'])->name('admin.penghuni.hapusKamarSewa');

});

// Halaman Landing Page Publik (Udah Rapi & Gak Balatak)
Route::get('/', function () {
    // Arahkan ke folder 'publik' dan file 'landingpage'
    return view('publik.landingpage'); 
})->name('landing');