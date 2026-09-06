<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PresensiSiswa extends Model
{
    protected $table = 'presensi_siswa';
    protected $fillable = ['siswa_id', 'kelas_id', 'tanggal', 'status', 'keterangan'];
}
