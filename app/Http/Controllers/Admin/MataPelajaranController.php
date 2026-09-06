<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;

class MataPelajaranController extends Controller
{

    public function index()
    {
        $mapel = MataPelajaran::orderBy('nama_mapel')->paginate(10);
        return view('admin.mapel.index', compact('mapel'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_mapel' => 'required|string|max:50|unique:mata_pelajaran,kode_mapel',
            'nama_mapel' => 'required|string|max:255',
        ]);

        MataPelajaran::create($validated);
        return redirect()->route('admin.mata-pelajaran.index')->with('success', 'Mata Pelajaran berhasil ditambahkan.');
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'kode_mapel' => 'required|string|max:50|unique:mata_pelajaran,kode_mapel,' . $id,
            'nama_mapel' => 'required|string|max:255',
        ]);

        $mapel = MataPelajaran::findOrFail($id);
        $mapel->update($validated);

        return redirect()->route('admin.mata-pelajaran.index')->with('success', 'Mata Pelajaran berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        try {
            $mapel = MataPelajaran::findOrFail($id);
            $mapel->delete();

            return redirect()->route('admin.mata-pelajaran.index')->with('success', 'Mata Pelajaran berhasil dihapus.');
        } catch (\Illuminate\Database\QueryException $e) {

            if ($e->errorInfo[1] == 1451) {
                return redirect()->route('admin.mata-pelajaran.index')->withErrors('Gagal menghapus! Mata pelajaran ini tidak dapat dihapus karena masih digunakan oleh data Guru, Jadwal Pelajaran, atau Nilai Siswa. Silakan ubah atau hapus data terkait terlebih dahulu.');
            }


            return redirect()->route('admin.mata-pelajaran.index')->withErrors('Terjadi kesalahan pada database saat mencoba menghapus data.');
        }
    }
}
