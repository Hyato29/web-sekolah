<?php

use App\Http\Controllers\Admin\GaleriController;
use App\Http\Controllers\Admin\GuruController;
use App\Http\Controllers\Admin\JadwalController;
use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\MataPelajaranController;
use App\Http\Controllers\Admin\PengumumanController;
use App\Http\Controllers\Admin\PPDBAdminController;
use App\Http\Controllers\Admin\PresensiController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Guru\NilaiController;
use App\Http\Controllers\PPDBController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Siswa\AkademikController;
use App\Http\Controllers\Siswa\PengumumanController as SiswaPengumumanController;
use App\Http\Controllers\Siswa\PresensiController as SiswaPresensi;
use App\Http\Controllers\Guru\PresensiController as GuruPresensi;
use App\Http\Controllers\Guru\JadwalController as GuruJadwal;
use App\Models\Galeri;
use App\Models\Pengumuman;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {

    $pengumuman = Pengumuman::whereNull('kelas_id')
        ->latest('tanggal_publish')
        ->take(3)->get();


    $galeri = Galeri::latest()->take(6)->get();

    return view('welcome', compact('pengumuman', 'galeri'));
});

Route::get('/home', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('home');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

Route::get('/ppdb/daftar', [PPDBController::class, 'create'])->name('ppdb.create');
Route::post('/ppdb/daftar', [PPDBController::class, 'store'])->name('ppdb.store');
Route::get('/ppdb/cek-status', [PPDBController::class, 'cekStatus'])->name('ppdb.cek_status');

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('dashboard');
        Route::resource('kelas', KelasController::class)->except(['create', 'show', 'edit']);
        Route::resource('siswa', SiswaController::class)->except(['create', 'show', 'edit', 'update']);
        Route::resource('guru', GuruController::class)->except(['create', 'show', 'edit', 'update']);
        Route::get('/ppdb', [PPDBAdminController::class, 'index'])->name('ppdb.index');
        Route::post('/ppdb/{id}/status', [PPDBAdminController::class, 'updateStatus'])->name('ppdb.update_status');
        Route::get('/ppdb/diterima', [PPDBAdminController::class, 'diterima'])->name('ppdb.diterima');
        Route::resource('pengumuman', PengumumanController::class)->except(['create', 'show', 'edit']);
        Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal.index');
        Route::post('/jadwal', [JadwalController::class, 'store'])->name('jadwal.store');
        Route::delete('/jadwal/{id}', [JadwalController::class, 'destroy'])->name('jadwal.destroy');
        Route::resource('mata-pelajaran', MataPelajaranController::class)->except(['create', 'show', 'edit']);
        Route::get('/rekap-absensi', [PresensiController::class, 'index'])->name('rekap_absensi');
        Route::resource('galeri', GaleriController::class)->only(['index', 'store', 'destroy']);
    });

    Route::middleware('role:guru')->prefix('guru')->name('guru.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'guruDashboard'])->name('dashboard');
        Route::get('/nilai', [NilaiController::class, 'index'])->name('nilai.index');
        Route::post('/nilai', [NilaiController::class, 'store'])->name('nilai.store');
        Route::post('/presensi', [GuruPresensi::class, 'store'])->name('presensi.store');
        Route::get('/jadwal', [GuruJadwal::class, 'index'])->name('jadwal');
    });

    Route::middleware('role:siswa')->prefix('siswa')->name('siswa.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'siswaDashboard'])->name('dashboard');
        Route::get('/nilai', [AkademikController::class, 'nilai'])->name('nilai');
        Route::get('/jadwal', [AkademikController::class, 'jadwal'])->name('jadwal');
        Route::get('/pengumuman', [SiswaPengumumanController::class, 'index'])->name('pengumuman');
        Route::post('/presensi', [SiswaPresensi::class, 'store'])->name('presensi.store');
    });
});

require __DIR__ . '/auth.php';
