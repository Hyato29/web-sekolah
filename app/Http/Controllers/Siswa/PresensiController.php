<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PresensiSiswa;
use Illuminate\Support\Facades\Auth;

class PresensiController extends Controller
{
    public function store(Request $request)
    {
        $siswa = Auth::user()->siswa;

        if (!$siswa) return back()->withErrors('Gagal: Profil siswa Anda tidak ditemukan.');

        $request->validate([
            'status' => 'required|in:Hadir,Sakit,Izin',
            'keterangan' => 'nullable|string|max:255'
        ]);

        PresensiSiswa::updateOrCreate(
            ['siswa_id' => $siswa->id, 'tanggal' => now()->toDateString()],
            [
                'kelas_id' => $siswa->kelas_id,
                'status' => $request->status,
                'keterangan' => $request->keterangan
            ]
        );

        return back()->with('success', 'Berhasil! Absensi hari ini telah dicatat.');
    }
}
