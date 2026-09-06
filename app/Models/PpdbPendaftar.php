<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PpdbPendaftar extends Model
{
    use SoftDeletes;

    protected $table = 'ppdb_pendaftar';

    protected $fillable = [
        'nomor_pendaftaran',
        'nama_lengkap',
        'asal_sekolah',
        'nama_orang_tua',
        'nomor_telepon',
        'alamat_lengkap',
        'berkas_dokumen',
        'status'
    ];
}
