<x-app-layout>
    <x-slot name="header">Portal Siswa</x-slot>

    @if (!$siswa)
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg shadow-sm">
            Data profil siswa Anda belum lengkap. Silakan hubungi Admin Tata Usaha untuk melengkapi data Anda.
        </div>
    @else
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Halo, {{ Auth::user()->name }}! 🎓</h2>
                <p class="text-gray-500 text-sm mt-1">Kelas: {{ $siswa->kelas->nama_kelas ?? '-' }} | NISN:
                    {{ $siswa->nisn }}</p>
            </div>
        </div>

        <!-- 4 Kolom Ringkasan Statistik -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            <div
                class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-center transition hover:shadow-md">
                <p class="text-gray-500 text-xs mb-1 font-medium uppercase tracking-wide">Mapel Hari Ini</p>
                <h3 class="text-2xl font-bold text-[#1E3A8A]">{{ $jadwalHariIni->count() }} <span
                        class="text-sm font-normal text-gray-400">Pelajaran</span></h3>
            </div>
            <div
                class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-center transition hover:shadow-md">
                <p class="text-gray-500 text-xs mb-1 font-medium uppercase tracking-wide">Kehadiran (Bulan Ini)</p>
                <h3 class="text-2xl font-bold text-green-600">{{ $persentaseHadir }}%</h3>
            </div>
            <div
                class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-center transition hover:shadow-md">
                <p class="text-gray-500 text-xs mb-1 font-medium uppercase tracking-wide">Nilai Rata-rata</p>
                <h3 class="text-2xl font-bold text-amber-500">{{ number_format($rataNilai, 1) }}</h3>
            </div>
            <a href="{{ route('siswa.nilai') }}"
                class="bg-[#1E3A8A] text-white p-5 rounded-2xl shadow-sm flex flex-col justify-center relative overflow-hidden group hover:bg-blue-800 transition">
                <p class="text-blue-200 text-xs mb-1 font-medium uppercase tracking-wide">Status Akademik</p>
                <h3 class="text-lg font-bold flex items-center gap-2">Lihat Rapor <i
                        class='bx bx-right-arrow-alt text-xl group-hover:translate-x-1 transition'></i></h3>
            </a>
        </div>

        <!-- Notifikasi -->
        @if (session('success'))
            <div
                class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl mb-6 flex items-center gap-2 shadow-sm">
                <i class='bx bx-check-circle text-xl'></i> <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif
        @if ($errors->any())
            <div
                class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl mb-6 flex items-center gap-2 shadow-sm">
                <i class='bx bx-error-circle text-xl'></i> <span class="font-medium">{{ $errors->first() }}</span>
            </div>
        @endif

        <!-- Widget Absensi Mandiri -->
        <div
            class="bg-gradient-to-r from-blue-50 to-white rounded-2xl shadow-sm border border-blue-100 p-6 mb-8 flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-4">
                <div
                    class="w-12 h-12 bg-white rounded-full shadow-sm flex items-center justify-center text-blue-600 text-2xl border border-blue-100">
                    <i class='bx bx-fingerprint'></i>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800 text-lg">Presensi Hari Ini</h3>
                    <p class="text-sm text-gray-500">{{ now()->translatedFormat('l, d F Y') }}</p>
                </div>
            </div>

            @if ($presensiHariIni)
                <div
                    class="px-5 py-2.5 rounded-xl border flex items-center gap-2 font-bold text-sm
                    {{ $presensiHariIni->status == 'Hadir' ? 'bg-green-100 text-green-700 border-green-200' : 'bg-amber-100 text-amber-700 border-amber-200' }}">
                    <i class='bx bx-check-double text-xl'></i> Status: {{ $presensiHariIni->status }}
                </div>
            @else
                <form action="{{ route('siswa.presensi.store') }}" method="POST" class="flex w-full md:w-auto gap-2"
                    x-data="{ status: 'Hadir' }">
                    @csrf
                    <select name="status" x-model="status"
                        class="border-gray-300 rounded-lg py-2 focus:ring-[#1E3A8A] text-sm font-bold bg-white shadow-sm">
                        <option value="Hadir">Hadir</option>
                        <option value="Sakit">Sakit</option>
                        <option value="Izin">Izin</option>
                    </select>
                    <input x-show="status !== 'Hadir'" type="text" name="keterangan"
                        placeholder="Keterangan singkat..." :required="status !== 'Hadir'"
                        class="border-gray-300 rounded-lg py-2 focus:ring-[#1E3A8A] text-sm w-40 shadow-sm">

                    <button type="submit"
                        class="bg-[#1E3A8A] hover:bg-blue-800 text-white font-bold px-6 py-2 rounded-lg transition shadow-md whitespace-nowrap">
                        Absen Sekarang
                    </button>
                </form>
            @endif
        </div>

        <!-- Area Konten Utama -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <!-- Widget Jadwal Hari Ini -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 mb-5 flex items-center gap-2">
                    <i class='bx bx-time-five text-amber-500 text-xl'></i> Jadwal Pelajaran Hari Ini
                </h3>

                <div class="relative border-l-2 border-gray-100 ml-3 space-y-6">
                    @forelse($jadwalHariIni as $jadwal)
                        @php
                            $waktuSekarang = now()->format('H:i:s');
                            // Pengecekan jam aktif
                            $isActive = $waktuSekarang >= $jadwal->jam_mulai && $waktuSekarang <= $jadwal->jam_selesai;
                        @endphp
                        <div class="relative pl-6">
                            @if ($isActive)
                                <!-- Indikator Sedang Berjalan -->
                                <div
                                    class="absolute -left-2 top-1.5 w-4 h-4 bg-amber-400 rounded-full border-4 border-white shadow-sm ring-2 ring-amber-100">
                                </div>
                                <p class="text-xs text-amber-600 font-semibold mb-0.5">
                                    {{ substr($jadwal->jam_mulai, 0, 5) }} - {{ substr($jadwal->jam_selesai, 0, 5) }}
                                    (Sedang Berjalan)
                                </p>
                                <h4 class="font-bold text-[#1E3A8A] text-lg">{{ $jadwal->mapel->nama_mapel }}</h4>
                            @else
                                <!-- Indikator Standar -->
                                <div
                                    class="absolute -left-1.5 top-1.5 w-3 h-3 bg-gray-300 rounded-full border-2 border-white">
                                </div>
                                <p class="text-xs text-gray-400 mb-0.5">{{ substr($jadwal->jam_mulai, 0, 5) }} -
                                    {{ substr($jadwal->jam_selesai, 0, 5) }}</p>
                                <h4 class="font-bold text-gray-800">{{ $jadwal->mapel->nama_mapel }}</h4>
                            @endif
                            <p class="text-sm text-gray-500 flex items-center gap-1 mt-1"><i class='bx bx-user-pin'></i>
                                {{ $jadwal->guru->user->name ?? '-' }}</p>
                        </div>
                    @empty
                        <div class="pl-6 text-gray-400 text-sm py-4">Tidak ada jadwal untuk hari ini. Waktunya
                            istirahat!</div>
                    @endforelse
                </div>
            </div>

            <!-- Widget Pengumuman Terbaru -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col">
                <div class="flex justify-between items-center mb-5">
                    <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                        <i class='bx bxs-megaphone text-blue-500 text-xl'></i> Pengumuman Terbaru
                    </h3>
                    <a href="{{ route('siswa.pengumuman') }}"
                        class="text-xs text-[#1E3A8A] font-bold hover:underline">Lihat Semua</a>
                </div>

                <div class="space-y-4 flex-1">
                    @forelse($pengumumanTerbaru as $pengumuman)
                        <div
                            class="p-4 rounded-xl border {{ $pengumuman->kategori == 'Penting' ? 'bg-red-50 border-red-100' : 'bg-gray-50 border-gray-100' }} transition hover:shadow-sm">
                            <div class="flex justify-between items-start mb-2 gap-2">
                                <h4 class="font-bold text-gray-900 leading-tight">{{ $pengumuman->judul }}</h4>
                                @if ($pengumuman->kategori == 'Penting')
                                    <span
                                        class="text-[10px] bg-red-100 text-red-600 px-2 py-0.5 rounded-full font-bold uppercase shrink-0">Penting</span>
                                @endif
                            </div>
                            <p class="text-sm text-gray-600 line-clamp-2">{{ $pengumuman->isi }}</p>
                            <p class="text-xs text-gray-400 mt-3 font-medium"><i class='bx bx-time'></i>
                                {{ $pengumuman->tanggal_publish->diffForHumans() }}</p>
                        </div>
                    @empty
                        <div
                            class="text-center py-10 text-gray-400 text-sm flex flex-col items-center justify-center h-full">
                            <i class='bx bx-message-square-check text-4xl mb-2 text-gray-300'></i>
                            <p>Belum ada pengumuman terbaru saat ini.</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    @endif
</x-app-layout>
