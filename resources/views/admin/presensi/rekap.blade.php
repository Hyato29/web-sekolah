<x-app-layout>
    <x-slot name="header">Rekapitulasi Absensi Bulanan</x-slot>

    <!-- State Alpine.js untuk Tab -->
    <div x-data="{ tab: 'siswa' }" class="space-y-6">

        <!-- Area Header & Filter Bulan -->
        <div
            class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="text-xl font-bold text-gray-800">Data Presensi: {{ $namaBulan }}</h2>
                <p class="text-sm text-gray-500">Pantau rekap kehadiran staf dan peserta didik.</p>
            </div>

            <form method="GET" action="{{ route('admin.rekap_absensi') }}" class="flex gap-2 w-full md:w-auto">
                <select name="bulan" class="rounded-lg border-gray-300 focus:ring-[#1E3A8A] text-sm">
                    @for ($i = 1; $i <= 12; $i++)
                        <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}" {{ $bulan == $i ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                        </option>
                    @endfor
                </select>
                <select name="tahun" class="rounded-lg border-gray-300 focus:ring-[#1E3A8A] text-sm">
                    @for ($i = date('Y') - 2; $i <= date('Y'); $i++)
                        <option value="{{ $i }}" {{ $tahun == $i ? 'selected' : '' }}>{{ $i }}
                        </option>
                    @endfor
                </select>
                <button type="submit"
                    class="bg-[#1E3A8A] hover:bg-blue-800 text-white px-4 py-2 rounded-lg font-medium transition">
                    Filter Data
                </button>
            </form>
        </div>

        <!-- Tombol Navigasi Tab -->
        <div class="flex gap-4 border-b border-gray-200 px-2">
            <button @click="tab = 'siswa'"
                :class="tab === 'siswa' ? 'border-[#1E3A8A] text-[#1E3A8A] border-b-4' :
                    'border-transparent text-gray-500 hover:text-gray-700'"
                class="py-2 px-4 font-bold transition-all text-lg flex items-center gap-2">
                <i class='bx bx-user'></i> Rekap Absen Siswa
            </button>
            <button @click="tab = 'guru'"
                :class="tab === 'guru' ? 'border-amber-400 text-gray-800 border-b-4' :
                    'border-transparent text-gray-500 hover:text-gray-700'"
                class="py-2 px-4 font-bold transition-all text-lg flex items-center gap-2">
                <i class='bx bx-briefcase'></i> Rekap Absen Guru
            </button>
        </div>

        <!-- Tab Konten: SISWA -->
        <div x-show="tab === 'siswa'" x-transition.opacity
            class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 flex justify-between items-center border-b border-gray-100">
                <h3 class="font-bold text-gray-700">Daftar Kehadiran Siswa</h3>
                <button onclick="window.print()" class="text-[#1E3A8A] text-sm font-bold hover:underline"><i
                        class='bx bx-printer'></i> Cetak Siswa</button>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-white text-gray-500 text-sm border-b border-gray-100">
                            <th class="py-3 px-6 font-semibold w-16">No</th>
                            <th class="py-3 px-6 font-semibold">NISN</th>
                            <th class="py-3 px-6 font-semibold">Nama Siswa</th>
                            <th class="py-3 px-6 font-semibold">Kelas</th>
                            <th class="py-3 px-6 font-semibold text-center text-green-600">Hadir</th>
                            <th class="py-3 px-6 font-semibold text-center text-amber-500">Sakit</th>
                            <th class="py-3 px-6 font-semibold text-center text-blue-500">Izin</th>
                            <th class="py-3 px-6 font-semibold text-center text-red-500">Alpa</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 text-sm">
                        @forelse($rekapSiswa as $index => $item)
                            <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                                <td class="py-3 px-6 text-gray-500">{{ $loop->iteration }}</td>
                                <td class="py-3 px-6 font-mono text-gray-500">{{ $item->nisn }}</td>
                                <td class="py-3 px-6 font-bold text-gray-900">{{ $item->user->name }}</td>
                                <td class="py-3 px-6"><span
                                        class="bg-gray-100 px-3 py-1 rounded-full text-xs font-semibold">{{ $item->kelas->nama_kelas ?? '-' }}</span>
                                </td>
                                <td class="py-3 px-6 text-center font-bold text-green-600 bg-green-50/30">
                                    {{ $item->hadir }}</td>
                                <td class="py-3 px-6 text-center font-bold text-amber-500 bg-amber-50/30">
                                    {{ $item->sakit }}</td>
                                <td class="py-3 px-6 text-center font-bold text-blue-500 bg-blue-50/30">
                                    {{ $item->izin }}</td>
                                <td class="py-3 px-6 text-center font-bold text-red-500 bg-red-50/30">
                                    {{ $item->alpa }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="py-8 text-center text-gray-500">Belum ada data siswa.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tab Konten: GURU -->
        <div x-show="tab === 'guru'" x-transition.opacity style="display: none;"
            class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 flex justify-between items-center border-b border-gray-100">
                <h3 class="font-bold text-gray-700">Daftar Kehadiran Tenaga Pengajar</h3>
                <button onclick="window.print()" class="text-[#1E3A8A] text-sm font-bold hover:underline"><i
                        class='bx bx-printer'></i> Cetak Guru</button>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-white text-gray-500 text-sm border-b border-gray-100">
                            <th class="py-3 px-6 font-semibold w-16">No</th>
                            <th class="py-3 px-6 font-semibold">NIP</th>
                            <th class="py-3 px-6 font-semibold">Nama Pengajar</th>
                            <th class="py-3 px-6 font-semibold">Mata Pelajaran</th>
                            <th class="py-3 px-6 font-semibold text-center text-green-600">Hadir</th>
                            <th class="py-3 px-6 font-semibold text-center text-amber-500">Sakit</th>
                            <th class="py-3 px-6 font-semibold text-center text-blue-500">Izin</th>
                            <th class="py-3 px-6 font-semibold text-center text-red-500">Alpa</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 text-sm">
                        @forelse($rekapGuru as $index => $item)
                            <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                                <td class="py-3 px-6 text-gray-500">{{ $loop->iteration }}</td>
                                <td class="py-3 px-6 font-mono text-gray-500">{{ $item->nip ?? '-' }}</td>
                                <td class="py-3 px-6 font-bold text-gray-900">{{ $item->user->name }}</td>
                                <td class="py-3 px-6 text-sm">{{ $item->mapel->nama_mapel ?? '-' }}</td>
                                <td class="py-3 px-6 text-center font-bold text-green-600 bg-green-50/30">
                                    {{ $item->hadir }}</td>
                                <td class="py-3 px-6 text-center font-bold text-amber-500 bg-amber-50/30">
                                    {{ $item->sakit }}</td>
                                <td class="py-3 px-6 text-center font-bold text-blue-500 bg-blue-50/30">
                                    {{ $item->izin }}</td>
                                <td class="py-3 px-6 text-center font-bold text-red-500 bg-red-50/30">
                                    {{ $item->alpa }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="py-8 text-center text-gray-500">Belum ada data tenaga
                                    pengajar.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>
