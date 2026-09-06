<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Siswa;
use App\Models\Nilai;
use Illuminate\Support\Facades\Auth;

class NilaiController extends Controller
{
    public function index(Request $request)
    {
        $kelas = Kelas::all();
        $mapel = MataPelajaran::all();

        $siswa = collect();
        $selectedKelas = $request->kelas_id;


        if ($selectedKelas) {
            $siswa = Siswa::where('kelas_id', $selectedKelas)->orderBy('nama_wali')->get();
        }

        return view('guru.nilai.index', compact('kelas', 'mapel', 'siswa', 'selectedKelas'));
    }


    public function store(Request $request)
    {

        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'mapel_id' => 'required|exists:mata_pelajaran,id',
            'jenis_nilai' => 'required|in:Tugas,UTS,UAS',
            'semester' => 'required|integer|min:1|max:2',
            'tahun_ajaran' => 'required|string',
            'nilai' => 'required|array',
            'nilai.*' => 'nullable|numeric|min:0|max:100',
        ]);


        $guru = Auth::user()->guru;

        if (!$guru) {
            return redirect()->back()->withErrors('Akses ditolak: Akun Anda belum memiliki profil Guru di database. Silakan hubungi Admin TU untuk melengkapi data Guru Anda.');
        }

        $berhasil = 0;


        foreach ($request->nilai as $siswa_id => $nilai_angka) {
            if (!is_null($nilai_angka)) {
                Nilai::updateOrCreate(
                    [
                        'siswa_id' => $siswa_id,
                        'mapel_id' => $request->mapel_id,
                        'jenis_nilai' => $request->jenis_nilai,
                        'semester' => $request->semester,
                        'tahun_ajaran' => $request->tahun_ajaran,
                    ],
                    [
                        'guru_id' => $guru->id,
                        'nilai' => $nilai_angka,
                    ]
                );
                $berhasil++;
            }
        }

        return redirect()->route('guru.nilai.index', ['kelas_id' => $request->kelas_id])
            ->with('success', "$berhasil data nilai siswa berhasil disimpan!");
    }
}
