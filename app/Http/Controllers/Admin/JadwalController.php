<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalPelajaran;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Guru;
use Illuminate\Http\Request;

class JadwalController extends Controller
{

    public function index(Request $request)
    {
        $kelas = Kelas::orderBy('nama_kelas')->get();
        $mapel = MataPelajaran::orderBy('nama_mapel')->get();
        $guru = Guru::with('user')->get();

        $selectedKelas = $request->query('kelas_id');
        $jadwal = collect();


        if ($selectedKelas) {
            $jadwal = JadwalPelajaran::with(['mapel', 'guru.user'])
                ->where('kelas_id', $selectedKelas)
                ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu')")
                ->orderBy('jam_mulai')
                ->get();
        }

        return view('admin.jadwal.index', compact('kelas', 'mapel', 'guru', 'jadwal', 'selectedKelas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'mapel_id' => 'required|exists:mata_pelajaran,id',
            'guru_id' => 'required|exists:guru,id',
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
        ]);


        $bentrok = JadwalPelajaran::where('guru_id', $request->guru_id)
            ->where('hari', $request->hari)
            ->where(function ($query) use ($request) {
                $query->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])
                    ->orWhereBetween('jam_selesai', [$request->jam_mulai, $request->jam_selesai]);
            })->exists();

        if ($bentrok) {
            return redirect()->back()->withErrors('Guru tersebut sudah memiliki jadwal mengajar di jam dan hari tersebut.');
        }

        JadwalPelajaran::create($validated);

        return redirect()->route('admin.jadwal.index', ['kelas_id' => $request->kelas_id])
            ->with('success', 'Jadwal pelajaran berhasil ditambahkan.');
    }

    public function destroy(string $id)
    {
        $jadwal = JadwalPelajaran::findOrFail($id);
        $kelas_id = $jadwal->kelas_id;
        $jadwal->delete();

        return redirect()->route('admin.jadwal.index', ['kelas_id' => $kelas_id])
            ->with('success', 'Jadwal pelajaran berhasil dihapus.');
    }
}
