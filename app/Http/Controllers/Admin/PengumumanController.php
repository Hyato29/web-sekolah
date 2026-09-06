<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengumumanController extends Controller
{

    public function index()
    {
        $pengumuman = Pengumuman::with(['author', 'kelas'])->latest('tanggal_publish')->paginate(10);
        $kelas = Kelas::orderBy('nama_kelas')->get();

        return view('admin.pengumuman.index', compact('pengumuman', 'kelas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'kategori' => 'required|in:Akademik,Informasi Umum,Kegiatan,Penting',
            'kelas_id' => 'nullable|exists:kelas,id',
            'tanggal_publish' => 'required|date',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $validated['user_id'] = Auth::id();

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('pengumuman', 'public');
        }

        Pengumuman::create($validated);
        return redirect()->route('admin.pengumuman.index')->with('success', 'Pengumuman berhasil dipublikasikan.');
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'kategori' => 'required|in:Akademik,Informasi Umum,Kegiatan,Penting',
            'kelas_id' => 'nullable|exists:kelas,id',
            'tanggal_publish' => 'required|date',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $pengumuman = Pengumuman::findOrFail($id);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('pengumuman', 'public');
        }

        $pengumuman->update($validated);
        return redirect()->route('admin.pengumuman.index')->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        Pengumuman::findOrFail($id)->delete();
        return redirect()->route('admin.pengumuman.index')->with('success', 'Pengumuman berhasil dihapus.');
    }
}
