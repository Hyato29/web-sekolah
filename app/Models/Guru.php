<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Guru extends Model
{
    use SoftDeletes;

    protected $table = 'guru';

    protected $fillable = [
        'user_id',
        'nip',
        'mapel_id'
    ];

    /**
     * Relasi ke model User (1 Guru memiliki 1 Akun Login)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke model MataPelajaran (1 Guru mengampu 1 Mata Pelajaran spesifik)
     */
    public function mapel()
    {
        return $this->belongsTo(MataPelajaran::class, 'mapel_id');
    }

    /**
     * Relasi ke model Nilai (1 Guru dapat memberikan banyak Nilai)
     */
    public function nilai()
    {
        return $this->hasMany(Nilai::class);
    }

    public function presensi()
    {
        return $this->hasMany(PresensiGuru::class);
    }
}
