<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\PpdbPendaftar;
use App\Models\JadwalPelajaran;
use App\Models\Pengumuman;
use App\Models\Nilai;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->hasRole('guru')) {
            return redirect()->route('guru.dashboard');
        } elseif ($user->hasRole('siswa')) {
            return redirect()->route('siswa.dashboard');
        }

        abort(403, 'Role tidak dikenali');
    }

    public function adminDashboard()
    {

        $totalSiswa = Siswa::count();
        $totalGuru = Guru::count();
        $totalKelas = Kelas::count();
        $totalPPDB = PpdbPendaftar::count();


        $pendaftarTerbaru = PpdbPendaftar::where('status', 'Menunggu')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('totalSiswa', 'totalGuru', 'totalKelas', 'totalPPDB', 'pendaftarTerbaru'));
    }

    public function guruDashboard()
    {
        $guru = Auth::user()->guru;

        if (!$guru) {
            $totalKelas = 0;
            $totalSiswa = 0;
            $jadwalHariIni = collect();
        } else {

            $totalKelas = JadwalPelajaran::where('guru_id', $guru->id)->distinct('kelas_id')->count('kelas_id');


            $kelasDiajarIds = JadwalPelajaran::where('guru_id', $guru->id)->pluck('kelas_id');
            $totalSiswa = Siswa::whereIn('kelas_id', $kelasDiajarIds)->count();


            $mapHari = [
                'Monday' => 'Senin',
                'Tuesday' => 'Selasa',
                'Wednesday' => 'Rabu',
                'Thursday' => 'Kamis',
                'Friday' => 'Jumat',
                'Saturday' => 'Sabtu',
                'Sunday' => 'Minggu'
            ];
            $hariIni = $mapHari[now()->format('l')] ?? 'Senin';


            $jadwalHariIni = JadwalPelajaran::with('kelas')
                ->where('guru_id', $guru->id)
                ->where('hari', $hariIni)
                ->orderBy('jam_mulai')
                ->get();
        }

        $presensiHariIni = \App\Models\PresensiGuru::where('guru_id', $guru->id)->where('tanggal', now()->toDateString())->first();

        return view('guru.dashboard', compact('totalKelas', 'totalSiswa', 'jadwalHariIni', 'presensiHariIni'));
    }

    public function siswaDashboard()
    {
        $siswa = Auth::user()->siswa;

        if (!$siswa) {
            return view('siswa.dashboard', ['siswa' => null, 'rataNilai' => 0, 'jadwalHariIni' => collect(), 'pengumumanTerbaru' => collect()]);
        }


        $rataNilai = Nilai::where('siswa_id', $siswa->id)->avg('nilai') ?? 0;


        $mapHari = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu'
        ];
        $hariIni = $mapHari[now()->format('l')] ?? 'Senin';


        $jadwalHariIni = JadwalPelajaran::with(['mapel', 'guru.user'])
            ->where('kelas_id', $siswa->kelas_id)
            ->where('hari', $hariIni)
            ->orderBy('jam_mulai')
            ->get();


        $pengumumanTerbaru = Pengumuman::with('author')
            ->whereNull('kelas_id')
            ->orWhere('kelas_id', $siswa->kelas_id)
            ->orderBy('tanggal_publish', 'desc')
            ->take(3)
            ->get();

        $presensiHariIni = \App\Models\PresensiSiswa::where('siswa_id', $siswa->id)->where('tanggal', now()->toDateString())->first();

        $totalHariAbsen = \App\Models\PresensiSiswa::where('siswa_id', $siswa->id)->whereMonth('tanggal', now()->month)->count();
        $totalHadir = \App\Models\PresensiSiswa::where('siswa_id', $siswa->id)->where('status', 'Hadir')->whereMonth('tanggal', now()->month)->count();
        $persentaseHadir = $totalHariAbsen > 0 ? round(($totalHadir / $totalHariAbsen) * 100) : 0;

        return view('siswa.dashboard', compact('siswa', 'rataNilai', 'jadwalHariIni', 'pengumumanTerbaru', 'presensiHariIni', 'persentaseHadir'));
    }
}
