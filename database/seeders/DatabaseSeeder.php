<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Carbon\Carbon;


use App\Models\Role;
use App\Models\User;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\JadwalPelajaran;
use App\Models\Nilai;
use App\Models\Pengumuman;
use App\Models\PpdbPendaftar;
use App\Models\Galeri;
use App\Models\PresensiGuru;
use App\Models\PresensiSiswa;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $password = Hash::make('password123');

        $roles = [
            ['id' => 1, 'name' => 'admin'],
            ['id' => 2, 'name' => 'guru'],
            ['id' => 3, 'name' => 'siswa'],
        ];
        foreach ($roles as $role) {
            Role::updateOrCreate(['id' => $role['id']], $role);
        }

        User::updateOrCreate(
            ['email' => 'admin@sekolah.com'],
            ['name' => 'Admin Tata Usaha', 'password' => $password, 'role_id' => 1]
        );

        $dataKelas = [
            ['nama_kelas' => 'X MIPA 1', 'tahun_ajaran' => '2026/2027'],
            ['nama_kelas' => 'X MIPA 2', 'tahun_ajaran' => '2026/2027'],
            ['nama_kelas' => 'X IPS 1', 'tahun_ajaran' => '2026/2027'],
        ];
        foreach ($dataKelas as $k) {
            Kelas::create($k);
        }
        $kelasIds = Kelas::pluck('id')->toArray();

        $dataMapel = [
            ['kode_mapel' => 'MTK-W', 'nama_mapel' => 'Matematika Wajib'],
            ['kode_mapel' => 'BND-W', 'nama_mapel' => 'Bahasa Indonesia'],
            ['kode_mapel' => 'ENG-W', 'nama_mapel' => 'Bahasa Inggris'],
            ['kode_mapel' => 'IPA-F', 'nama_mapel' => 'Fisika'],
        ];
        foreach ($dataMapel as $m) {
            MataPelajaran::create($m);
        }
        $mapelIds = MataPelajaran::pluck('id')->toArray();

        $guruIds = [];
        foreach ($mapelIds as $index => $mapelId) {
            $userGuru = User::create([
                'name' => $faker->name . ', S.Pd',
                'email' => "guru" . ($index + 1) . "@sekolah.com",
                'password' => $password,
                'role_id' => 2
            ]);

            $guru = Guru::create([
                'user_id' => $userGuru->id,
                'nip' => $faker->unique()->numerify('198#########'),
                'mapel_id' => $mapelId,
            ]);
            $guruIds[] = $guru->id;
        }

        $siswaIds = [];
        for ($i = 1; $i <= 15; $i++) {
            $userSiswa = User::create([
                'name' => $faker->name,
                'email' => "siswa{$i}@sekolah.com",
                'password' => $password,
                'role_id' => 3
            ]);

            $siswa = Siswa::create([
                'user_id' => $userSiswa->id,
                'nisn' => $faker->unique()->numerify('00########'),
                'kelas_id' => $faker->randomElement($kelasIds),
                'alamat' => $faker->address,
                'nama_wali' => $faker->name('male'),
                'no_telp_wali' => $faker->phoneNumber,
            ]);
            $siswaIds[] = $siswa->id;
        }

        $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
        foreach ($kelasIds as $kelasId) {
            foreach ($hari as $h) {
                JadwalPelajaran::create([
                    'kelas_id' => $kelasId,
                    'mapel_id' => $faker->randomElement($mapelIds),
                    'guru_id' => $faker->randomElement($guruIds),
                    'hari' => $h,
                    'jam_mulai' => '07:30:00',
                    'jam_selesai' => '09:00:00',
                ]);
            }
        }

        $jenisNilai = ['Tugas', 'UTS', 'UAS'];
        foreach ($siswaIds as $siswaId) {
            foreach ($mapelIds as $mapelId) {
                foreach ($jenisNilai as $jenis) {
                    Nilai::create([
                        'siswa_id' => $siswaId,
                        'mapel_id' => $mapelId,
                        'guru_id' => $faker->randomElement($guruIds),
                        'jenis_nilai' => $jenis,
                        'semester' => 1,
                        'tahun_ajaran' => '2026/2027',
                        'nilai' => $faker->numberBetween(70, 100),
                    ]);
                }
            }
        }

        Pengumuman::create([
            'judul' => 'Persiapan Ujian Tengah Semester (UTS)',
            'isi' => 'Diberitahukan kepada seluruh siswa bahwa UTS Semester Ganjil TA 2026/2027 akan dilaksanakan mulai pertengahan Oktober. Harap mempersiapkan diri dengan baik.',
            'kategori' => 'Akademik',
            'kelas_id' => null,
            'user_id' => 1,
            'tanggal_publish' => Carbon::now()->subDays(2),
        ]);
        Pengumuman::create([
            'judul' => 'Jadwal Ekstrakurikuler Wajib',
            'isi' => 'Pramuka wajib bagi kelas X MIPA 1 akan diadakan setiap hari Jumat sore pukul 15.30 WITA.',
            'kategori' => 'Kegiatan',
            'kelas_id' => $kelasIds[0],
            'user_id' => 1,
            'tanggal_publish' => Carbon::now(),
        ]);

        for ($i = 1; $i <= 8; $i++) {
            PpdbPendaftar::create([
                'nomor_pendaftaran' => 'PPDB-2026-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'nama_lengkap' => $faker->name,
                'asal_sekolah' => 'SMP Negeri ' . $faker->numberBetween(1, 15) . ' Kota',
                'nama_orang_tua' => $faker->name,
                'nomor_telepon' => $faker->phoneNumber,
                'alamat_lengkap' => $faker->address,
                'status' => $faker->randomElement(['Menunggu', 'Diterima', 'Ditolak']),
            ]);
        }

        $galeriImages = [
            'Upacara Kemerdekaan 17 Agustus',
            'Juara 1 Lomba Cerdas Cermat',
            'Kegiatan Pramuka Persami'
        ];
        foreach ($galeriImages as $judul) {
            Galeri::create([
                'judul' => $judul,
                'keterangan' => 'Dokumentasi kegiatan siswa tahun 2026.',
                'foto' => 'galeri/placeholder.jpg',
            ]);
        }

        for ($d = 0; $d < 5; $d++) {
            $tanggal = Carbon::now()->subDays($d)->toDateString();


            foreach ($guruIds as $gId) {
                PresensiGuru::create([
                    'guru_id' => $gId,
                    'tanggal' => $tanggal,
                    'status' => $faker->randomElement(['Hadir', 'Hadir', 'Hadir', 'Sakit', 'Izin']),
                ]);
            }

            foreach ($siswaIds as $sId) {
                PresensiSiswa::create([
                    'siswa_id' => $sId,
                    'kelas_id' => Siswa::find($sId)->kelas_id,
                    'tanggal' => $tanggal,
                    'status' => $faker->randomElement(['Hadir', 'Hadir', 'Hadir', 'Hadir', 'Sakit', 'Alpa']),
                ]);
            }
        }
    }
}
