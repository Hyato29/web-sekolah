<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PpdbPendaftar;
use Illuminate\Support\Facades\Storage;

class PPDBController extends Controller
{

    public function create()
    {
        return view('ppdb.create');
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'asal_sekolah' => 'required|string|max:255',
            'nama_orang_tua' => 'required|string|max:255',
            'nomor_telepon' => 'required|string|max:20',
            'alamat_lengkap' => 'required|string',

            'berkas_dokumen' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);


        $tahun = date('Y');
        $lastPendaftar = PpdbPendaftar::whereYear('created_at', $tahun)->orderBy('id', 'desc')->first();
        $urutan = $lastPendaftar ? ((int) substr($lastPendaftar->nomor_pendaftaran, -4)) + 1 : 1;
        $nomorPendaftaran = 'PPDB-' . $tahun . '-' . str_pad($urutan, 4, '0', STR_PAD_LEFT);


        if ($request->hasFile('berkas_dokumen')) {
            $path = $request->file('berkas_dokumen')->store('berkas_ppdb', 'public');
            $validated['berkas_dokumen'] = $path;
        }

        $validated['nomor_pendaftaran'] = $nomorPendaftaran;
        $validated['status'] = 'Menunggu';

        PpdbPendaftar::create($validated);

        return redirect()->route('ppdb.create')->with('success', 'Pendaftaran berhasil! Nomor Pendaftaran Anda: ' . $nomorPendaftaran . '. Harap simpan nomor ini untuk mengecek status.');
    }

    public function cekStatus(Request $request)
    {
        $pendaftar = null;
        $dicari = false;


        if ($request->filled('nomor_pendaftaran')) {
            $dicari = true;
            $pendaftar = PpdbPendaftar::where('nomor_pendaftaran', $request->nomor_pendaftaran)->first();
        }

        return view('ppdb.cek-status', compact('pendaftar', 'dicari'));
    }
}
