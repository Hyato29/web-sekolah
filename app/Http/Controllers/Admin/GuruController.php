<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\User;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class GuruController extends Controller
{
    public function index()
    {
        $guru = Guru::with(['user', 'mapel'])->latest()->paginate(10);
        $mapel = MataPelajaran::all();

        return view('admin.guru.index', compact('guru', 'mapel'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'nip' => 'nullable|string|unique:guru,nip',
            'mapel_id' => 'required|exists:mata_pelajaran,id',
        ]);

        DB::transaction(function () use ($validated) {

            $user = User::create([
                'name' => $validated['nama'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role_id' => 2,
            ]);


            Guru::create([
                'user_id' => $user->id,
                'nip' => $validated['nip'],
                'mapel_id' => $validated['mapel_id'],
            ]);
        });

        return redirect()->route('admin.guru.index')->with('success', 'Akun guru berhasil ditambahkan.');
    }

    public function destroy(string $id)
    {
        $guru = Guru::findOrFail($id);

        DB::transaction(function () use ($guru) {
            $guru->delete();
            User::destroy($guru->user_id);
        });

        return redirect()->route('admin.guru.index')->with('success', 'Akun guru berhasil dihapus.');
    }
}
