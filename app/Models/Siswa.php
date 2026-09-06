<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Siswa extends Model
{
    use SoftDeletes;

    protected $table = 'siswa';
    protected $fillable = ['user_id', 'nisn', 'kelas_id', 'alamat', 'nama_orang_tua'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
    public function presensi()
    {
        return $this->hasMany(PresensiSiswa::class);
    }
}
