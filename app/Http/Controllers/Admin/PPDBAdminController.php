<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PpdbPendaftar;

class PPDBAdminController extends Controller
{
    public function index()
    {
        $pendaftar = PpdbPendaftar::latest()->paginate(15);
        return view('admin.ppdb.index', compact('pendaftar'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Menunggu,Diterima,Ditolak,Revisi'
        ]);

        $pendaftar = PpdbPendaftar::findOrFail($id);
        $pendaftar->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status pendaftar ' . $pendaftar->nama_lengkap . ' berhasil diubah menjadi ' . $request->status);
    }

    public function diterima()
    {
        $pendaftar = PpdbPendaftar::where('status', 'Diterima')
            ->orderBy('nama_lengkap', 'asc')
            ->paginate(20);

        return view('admin.ppdb.diterima', compact('pendaftar'));
    }
}
