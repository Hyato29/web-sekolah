<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\User;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class SiswaController extends Controller
{
    public function index()
    {

        $siswa = Siswa::with(['user', 'kelas'])->latest()->paginate(10);
        $kelas = Kelas::all();

        return view('admin.siswa.index', compact('siswa', 'kelas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'nisn' => 'required|string|unique:siswa,nisn',
            'kelas_id' => 'required|exists:kelas,id',
            'alamat' => 'nullable|string',
        ]);


        DB::transaction(function () use ($validated) {

            $user = User::create([
                'name' => $validated['nama'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role_id' => 3,
            ]);


            Siswa::create([
                'user_id' => $user->id,
                'nisn' => $validated['nisn'],
                'kelas_id' => $validated['kelas_id'],
                'alamat' => $validated['alamat'],
            ]);
        });

        return redirect()->route('admin.siswa.index')->with('success', 'Akun siswa berhasil ditambahkan.');
    }

    public function destroy(string $id)
    {
        $siswa = Siswa::findOrFail($id);

        DB::transaction(function () use ($siswa) {

            $siswa->delete();

            User::destroy($siswa->user_id);
        });

        return redirect()->route('admin.siswa.index')->with('success', 'Akun siswa berhasil dihapus.');
    }
}
