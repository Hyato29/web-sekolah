<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PresensiGuru;
use Illuminate\Support\Facades\Auth;

class PresensiController extends Controller
{
    public function store(Request $request)
    {
        $guru = Auth::user()->guru;

        if (!$guru) return back()->withErrors('Gagal: Profil guru Anda tidak ditemukan.');

        $request->validate([
            'status' => 'required|in:Hadir,Sakit,Izin',
            'keterangan' => 'nullable|string|max:255'
        ]);

        PresensiGuru::updateOrCreate(
            ['guru_id' => $guru->id, 'tanggal' => now()->toDateString()],
            [
                'status' => $request->status,
                'keterangan' => $request->keterangan
            ]
        );

        return back()->with('success', 'Berhasil! Kehadiran Anda hari ini telah dicatat.');
    }
}
