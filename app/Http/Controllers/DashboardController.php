<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller {
    public function index() {
        $user = Auth::user();

        // Redirect dinamis berdasarkan role[cite: 1]
        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->hasRole('guru')) {
            return redirect()->route('guru.dashboard');
        } elseif ($user->hasRole('siswa')) {
            return redirect()->route('siswa.dashboard');
        }

        abort(403, 'Role tidak dikenali');
    }

    public function adminDashboard() {
        return view('admin.dashboard');
    }

    public function guruDashboard() {
        return view('guru.dashboard');
    }

    public function siswaDashboard() {
        return view('siswa.dashboard');
    }
}