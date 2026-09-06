<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Nilai extends Model
{
    use SoftDeletes;

    protected $table = 'nilai';
    protected $fillable = [
        'siswa_id',
        'mapel_id',
        'guru_id',
        'jenis_nilai',
        'nilai',
        'semester',
        'tahun_ajaran'
    ];

    // Relasi
    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
    public function mapel()
    {
        return $this->belongsTo(MataPelajaran::class);
    }
    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }
}
