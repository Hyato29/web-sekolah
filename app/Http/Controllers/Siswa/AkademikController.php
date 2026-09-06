<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Nilai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AkademikController extends Controller
{
    public function nilai(Request $request)
    {
        $siswa = Auth::user()->siswa;

        if (!$siswa) {
            return redirect()->route('siswa.dashboard')->withErrors('Profil akademik Anda belum lengkap. Silakan hubungi Tata Usaha.');
        }


        $semesterAktif = $request->query('semester', 1);


        $nilai = Nilai::with(['mapel', 'guru.user'])
            ->where('siswa_id', $siswa->id)
            ->where('semester', $semesterAktif)
            ->orderBy('created_at', 'desc')
            ->get();


        $rekapNilai = [];
        foreach ($nilai as $n) {
            $idMapel = $n->mapel_id;
            if (!isset($rekapNilai[$idMapel])) {
                $rekapNilai[$idMapel] = [
                    'nama_mapel' => $n->mapel->nama_mapel,
                    'guru' => $n->guru->user->name ?? '-',
                    'Tugas' => '-',
                    'UTS' => '-',
                    'UAS' => '-',
                ];
            }

            $rekapNilai[$idMapel][$n->jenis_nilai] = $n->nilai;
        }

        return view('siswa.nilai.index', compact('rekapNilai', 'semesterAktif'));
    }

    public function jadwal()
    {
        $siswa = Auth::user()->siswa;

        if (!$siswa) {
            return redirect()->route('siswa.dashboard')->withErrors('Profil akademik Anda belum lengkap.');
        }


        $jadwal = \App\Models\JadwalPelajaran::with(['mapel', 'guru.user'])
            ->where('kelas_id', $siswa->kelas_id)
            ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu')")
            ->orderBy('jam_mulai')
            ->get();


        $jadwalPerHari = $jadwal->groupBy('hari');

        return view('siswa.jadwal.index', compact('jadwalPerHari', 'siswa'));
    }
}
