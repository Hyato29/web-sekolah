<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    protected $table = 'pengumuman';

    protected $fillable = [
        'judul',
        'isi',
        'kategori',
        'gambar',
        'kelas_id',
        'user_id',
        'tanggal_publish'
    ];

    protected $casts = [
        'tanggal_publish' => 'datetime',
    ];

    // Relasi ke User (Penulis)
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke Kelas (Target)
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
}
