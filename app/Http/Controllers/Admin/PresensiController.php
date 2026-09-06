<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Guru;
use Carbon\Carbon;

class PresensiController extends Controller
{

    public function index(Request $request)
    {
        $bulan = $request->query('bulan', date('m'));
        $tahun = $request->query('tahun', date('Y'));


        $rekapGuru = Guru::with(['user', 'mapel'])->withCount([
            'presensi as hadir' => function ($q) use ($bulan, $tahun) {
                $q->where('status', 'Hadir')->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun);
            },
            'presensi as sakit' => function ($q) use ($bulan, $tahun) {
                $q->where('status', 'Sakit')->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun);
            },
            'presensi as izin' => function ($q) use ($bulan, $tahun) {
                $q->where('status', 'Izin')->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun);
            },
            'presensi as alpa' => function ($q) use ($bulan, $tahun) {
                $q->where('status', 'Alpa')->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun);
            },
        ])->get();


        $rekapSiswa = Siswa::with(['user', 'kelas'])->withCount([
            'presensi as hadir' => function ($q) use ($bulan, $tahun) {
                $q->where('status', 'Hadir')->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun);
            },
            'presensi as sakit' => function ($q) use ($bulan, $tahun) {
                $q->where('status', 'Sakit')->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun);
            },
            'presensi as izin' => function ($q) use ($bulan, $tahun) {
                $q->where('status', 'Izin')->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun);
            },
            'presensi as alpa' => function ($q) use ($bulan, $tahun) {
                $q->where('status', 'Alpa')->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun);
            },
        ])->get();


        $namaBulan = Carbon::createFromDate($tahun, $bulan, 1)->translatedFormat('F Y');

        return view('admin.presensi.rekap', compact('rekapGuru', 'rekapSiswa', 'bulan', 'tahun', 'namaBulan'));
    }
}
