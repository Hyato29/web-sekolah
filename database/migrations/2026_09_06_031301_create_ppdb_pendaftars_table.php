<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ppdb_pendaftar', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_pendaftaran')->unique();
            $table->string('nama_lengkap');
            $table->string('asal_sekolah');
            $table->string('nama_orang_tua');
            $table->string('nomor_telepon');
            $table->text('alamat_lengkap');
            $table->string('berkas_dokumen')->nullable();
            $table->enum('status', ['Menunggu', 'Diterima', 'Ditolak', 'Revisi'])->default('Menunggu');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ppdb_pendaftars');
    }
};
