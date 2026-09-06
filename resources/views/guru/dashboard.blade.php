<x-app-layout>
    <x-slot name="header">Dashboard Guru</x-slot>

    <!-- Banner Ucapan Selamat Datang -->
    <div class="bg-[#1E3A8A] rounded-2xl p-8 shadow-lg text-white mb-6 relative overflow-hidden">
        <div class="relative z-10">
            <h2 class="text-2xl md:text-3xl font-bold mb-2">Selamat Datang, Bapak/Ibu {{ Auth::user()->name }}!</h2>
            <p class="text-blue-100 mb-6 max-w-2xl text-sm md:text-base">Anda memiliki <strong
                    class="text-amber-400">{{ $jadwalHariIni->count() }} jadwal kelas</strong> yang harus diampu hari
                ini. Jangan lupa untuk memantau nilai dan absensi siswa di kelas Anda.</p>
            <a href="{{ route('guru.nilai.index') }}"
                class="inline-block bg-amber-400 hover:bg-amber-500 text-gray-900 font-bold px-6 py-2.5 rounded-lg transition-colors shadow-md">
                <i class='bx bx-edit-alt mr-1'></i> Input Nilai Kelas
            </a>
        </div>
        <!-- Ornamen Background -->
        <i class='bx bxs-graduation absolute -bottom-10 -right-10 text-9xl text-white/10'></i>
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

    <!-- Widget Absensi Mandiri Guru -->
    <div
        class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8 flex flex-col md:flex-row justify-between items-center gap-4">
        <div>
            <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                <i class='bx bx-calendar-check text-[#1E3A8A] text-xl'></i> Kehadiran Anda Hari Ini
            </h3>
            <p class="text-sm text-gray-500">{{ now()->translatedFormat('l, d F Y') }}</p>
        </div>

        @if ($presensiHariIni)
            <div
                class="bg-green-50 border border-green-200 text-green-700 px-5 py-2.5 rounded-xl flex items-center gap-3 shadow-sm">
                <i class='bx bx-check-circle text-2xl'></i>
                <div>
                    <p class="text-sm font-bold">Anda telah absen ({{ $presensiHariIni->status }})</p>
                    <p class="text-[11px] opacity-80">Sistem mencatat pada pukul
                        {{ $presensiHariIni->updated_at->format('H:i') }}</p>
                </div>
            </div>
        @else
            <form action="{{ route('guru.presensi.store') }}" method="POST"
                class="flex flex-wrap md:flex-nowrap gap-2 items-center w-full md:w-auto" x-data="{ status: 'Hadir' }">
                @csrf
                <select name="status" x-model="status"
                    class="border-gray-300 rounded-lg py-2.5 focus:ring-[#1E3A8A] text-sm font-bold shadow-sm">
                    <option value="Hadir">Hadir</option>
                    <option value="Sakit">Sakit</option>
                    <option value="Izin">Izin</option>
                </select>
                <input x-show="status !== 'Hadir'" type="text" name="keterangan" placeholder="Keterangan singkat..."
                    :required="status !== 'Hadir'"
                    class="border-gray-300 rounded-lg py-2.5 focus:ring-[#1E3A8A] text-sm w-full md:w-48 shadow-sm">

                <button type="submit"
                    class="bg-[#1E3A8A] hover:bg-blue-800 text-white font-bold px-6 py-2.5 rounded-lg transition shadow-md w-full md:w-auto whitespace-nowrap">
                    Kirim Absensi
                </button>
            </form>
        @endif
    </div>

    <!-- Area Konten Utama -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Kolom Kiri: Jadwal Mengajar (Lebih Lebar) -->
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col">
            <h3 class="text-lg font-bold text-gray-800 mb-5 flex items-center gap-2">
                <i class='bx bx-calendar text-[#1E3A8A] text-xl'></i> Jadwal Mengajar Anda
            </h3>

            <div class="space-y-4 flex-1">
                @forelse($jadwalHariIni as $jadwal)
                    @php
                        $waktuSekarang = now()->format('H:i:s');
                        // Logika status jadwal (Sedang Berjalan / Selesai / Akan Datang)
                        if ($waktuSekarang >= $jadwal->jam_mulai && $waktuSekarang <= $jadwal->jam_selesai) {
                            $status = 'Sedang Berjalan';
                            $badge = 'bg-amber-100 text-amber-700';
                            $border = 'border-l-4 border-l-amber-400 bg-amber-50/20';
                        } elseif ($waktuSekarang > $jadwal->jam_selesai) {
                            $status = 'Selesai';
                            $badge = 'bg-green-100 text-green-700';
                            $border = 'border border-gray-100 bg-gray-50';
                        } else {
                            $status = 'Akan Datang';
                            $badge = 'bg-blue-100 text-blue-700';
                            $border = 'border border-gray-100';
                        }
                    @endphp
                    <div
                        class="flex items-center justify-between p-4 rounded-xl {{ $border }} transition hover:shadow-sm">
                        <div class="flex items-center gap-4 md:gap-5">
                            <div
                                class="bg-white border border-gray-200 text-gray-700 px-4 py-2 rounded-lg font-bold text-center shadow-sm shrink-0">
                                <span
                                    class="block text-[10px] font-normal uppercase tracking-wider text-gray-400 mb-0.5">Jam
                                    Mulai</span>
                                <span class="text-lg">{{ substr($jadwal->jam_mulai, 0, 5) }}</span>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 text-lg">Kelas {{ $jadwal->kelas->nama_kelas }}</h4>
                                <p class="text-sm text-gray-500 font-medium mt-0.5">Selesai Pukul:
                                    {{ substr($jadwal->jam_selesai, 0, 5) }}</p>
                            </div>
                        </div>
                        <span
                            class="px-3 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider {{ $badge }} hidden sm:block">{{ $status }}</span>
                    </div>
                @empty
                    <div class="text-center py-12 text-gray-500 flex flex-col items-center justify-center">
                        <i class='bx bx-coffee text-5xl mb-3 text-gray-300'></i>
                        <p class="font-medium">Tidak ada jadwal mengajar untuk hari ini.</p>
                        <p class="text-sm">Selamat beristirahat atau menyiapkan materi untuk besok!</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Kolom Kanan: Statistik Guru -->
        <div class="space-y-6">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 transition hover:shadow-md">
                <div class="flex items-center gap-4 mb-2">
                    <div
                        class="w-14 h-14 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center text-3xl shrink-0">
                        <i class='bx bx-book-reader'></i>
                    </div>
                    <div>
                        <h4 class="text-4xl font-bold text-gray-900">{{ $totalKelas }}</h4>
                        <p class="text-sm font-medium text-gray-500">Total Kelas Diampu</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 transition hover:shadow-md">
                <div class="flex items-center gap-4 mb-2">
                    <div
                        class="w-14 h-14 rounded-full bg-green-100 text-green-600 flex items-center justify-center text-3xl shrink-0">
                        <i class='bx bx-user-check'></i>
                    </div>
                    <div>
                        <h4 class="text-4xl font-bold text-gray-900">{{ $totalSiswa }}</h4>
                        <p class="text-sm font-medium text-gray-500">Total Siswa Diajar</p>
                    </div>
                </div>
            </div>

            <!-- Quick Link / Shortcut Tambahan -->
            <div
                class="bg-gradient-to-br from-[#1E3A8A] to-blue-800 rounded-2xl p-6 text-white shadow-sm relative overflow-hidden">
                <div class="relative z-10">
                    <h4 class="font-bold text-lg mb-1">Pusat Bantuan</h4>
                    <p class="text-sm text-blue-200 mb-4">Butuh bantuan terkait jadwal atau sistem akademik?</p>
                    <a href="#"
                        class="inline-block text-sm font-bold bg-white text-[#1E3A8A] px-4 py-2 rounded-lg hover:bg-gray-50 transition shadow-sm">Hubungi
                        Admin TU</a>
                </div>
                <i class='bx bx-support absolute -bottom-4 -right-4 text-7xl text-white/10'></i>
            </div>
        </div>

    </div>
</x-app-layout>
