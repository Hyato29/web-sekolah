<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use Illuminate\Support\Facades\Auth;

class PengumumanController extends Controller
{
    public function index()
    {
        $siswa = Auth::user()->siswa;
        $kelas_id = $siswa ? $siswa->kelas_id : 0;

        $pengumuman = Pengumuman::with('author')
            ->whereNull('kelas_id')
            ->orWhere('kelas_id', $kelas_id)
            ->orderBy('tanggal_publish', 'desc')
            ->paginate(12);

        return view('siswa.pengumuman.index', compact('pengumuman'));
    }
}
