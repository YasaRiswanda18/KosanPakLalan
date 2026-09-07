<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use Illuminate\Http\Request;

class PengumumanController extends Controller
{
    public function index()
    {
        // Menampilkan pengumuman terbaru di atas
        $pengumumans = Pengumuman::orderBy('created_at', 'desc')->get();
        return view('admin.pengumuman.index', compact('pengumumans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi_pengumuman' => 'required|string',
            'kategori' => 'required|in:Info,Penting,Tagihan',
        ]);

        Pengumuman::create([
            'judul' => $request->judul,
            'isi_pengumuman' => $request->isi_pengumuman,
            'kategori' => $request->kategori,
            'status' => 'Aktif' // Otomatis aktif saat dibuat
        ]);

        return redirect()->route('admin.pengumuman.index')->with('success', 'Pengumuman berhasil disebarkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi_pengumuman' => 'required|string',
            'kategori' => 'required|in:Info,Penting,Tagihan',
            'status' => 'required|in:Aktif,Arsip'
        ]);

        $pengumuman = Pengumuman::findOrFail($id);
        $pengumuman->update($request->all());

        return redirect()->route('admin.pengumuman.index')->with('success', 'Pengumuman berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        $pengumuman->delete();

        return redirect()->route('admin.pengumuman.index')->with('success', 'Pengumuman berhasil dihapus!');
    }
}