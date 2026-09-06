<x-app-layout>
    <x-slot name="header">
        Laporan Nilai Akademik
    </x-slot>

    <div class="space-y-6">

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative">
                <span class="block sm:inline font-medium">{{ $errors->first() }}</span>
            </div>
        @endif

        <!-- Filter Semester & Info Ringkas -->
        <div
            class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-100 text-[#1E3A8A] rounded-full flex items-center justify-center text-2xl">
                    <i class='bx bx-award'></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-900">Rekap Nilai Siswa</h2>
                    <p class="text-sm text-gray-500">Tahun Ajaran 2026/2027</p>
                </div>
            </div>

            <form method="GET" action="{{ route('siswa.nilai') }}" class="flex items-center gap-2">
                <label for="semester" class="text-sm font-medium text-gray-700">Pilih Semester:</label>
                <select name="semester" id="semester" onchange="this.form.submit()"
                    class="rounded-lg border-gray-300 py-2 px-3 border focus:ring-[#1E3A8A] text-sm font-bold bg-gray-50">
                    <option value="1" {{ $semesterAktif == 1 ? 'selected' : '' }}>Semester 1 (Ganjil)</option>
                    <option value="2" {{ $semesterAktif == 2 ? 'selected' : '' }}>Semester 2 (Genap)</option>
                </select>
            </form>
        </div>

        <!-- Tabel Nilai Akademik -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-[#1E3A8A] text-white text-sm">
                            <th class="py-4 px-6 font-semibold w-16 text-center">No</th>
                            <th class="py-4 px-6 font-semibold">Mata Pelajaran</th>
                            <th class="py-4 px-6 font-semibold">Guru Pengampu</th>
                            <th class="py-4 px-6 font-semibold text-center">Tugas</th>
                            <th class="py-4 px-6 font-semibold text-center">UTS</th>
                            <th class="py-4 px-6 font-semibold text-center">UAS</th>
                            <th class="py-4 px-6 font-semibold text-center bg-blue-900">Nilai Akhir</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 text-sm">
                        @php $no = 1; @endphp
                        @forelse($rekapNilai as $mapel)
                            @php
                                // Menghitung nilai akhir sederhana (Tugas 30%, UTS 30%, UAS 40%)
                                $valTugas = is_numeric($mapel['Tugas']) ? $mapel['Tugas'] : 0;
                                $valUTS = is_numeric($mapel['UTS']) ? $mapel['UTS'] : 0;
                                $valUAS = is_numeric($mapel['UAS']) ? $mapel['UAS'] : 0;

                                $isLengkap =
                                    is_numeric($mapel['Tugas']) &&
                                    is_numeric($mapel['UTS']) &&
                                    is_numeric($mapel['UAS']);
                                $nilaiAkhir = $valTugas * 0.3 + $valUTS * 0.3 + $valUAS * 0.4;
                            @endphp
                            <tr class="border-b border-gray-100 hover:bg-blue-50/30 transition">
                                <td class="py-4 px-6 text-center text-gray-500">{{ $no++ }}</td>
                                <td class="py-4 px-6 font-bold text-gray-900">{{ $mapel['nama_mapel'] }}</td>
                                <td class="py-4 px-6 text-gray-500">{{ $mapel['guru'] }}</td>

                                <!-- Kolom Nilai dengan pewarnaan dinamis -->
                                <td
                                    class="py-4 px-6 text-center font-semibold {{ is_numeric($mapel['Tugas']) && $mapel['Tugas'] < 75 ? 'text-red-600' : 'text-gray-800' }}">
                                    {{ $mapel['Tugas'] }}
                                </td>
                                <td
                                    class="py-4 px-6 text-center font-semibold {{ is_numeric($mapel['UTS']) && $mapel['UTS'] < 75 ? 'text-red-600' : 'text-gray-800' }}">
                                    {{ $mapel['UTS'] }}
                                </td>
                                <td
                                    class="py-4 px-6 text-center font-semibold {{ is_numeric($mapel['UAS']) && $mapel['UAS'] < 75 ? 'text-red-600' : 'text-gray-800' }}">
                                    {{ $mapel['UAS'] }}
                                </td>

                                <td class="py-4 px-6 text-center font-bold bg-gray-50 border-l border-gray-100">
                                    @if ($isLengkap)
                                        <span
                                            class="px-3 py-1 rounded-full text-xs {{ $nilaiAkhir >= 75 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                            {{ number_format($nilaiAkhir, 1) }}
                                        </span>
                                    @else
                                        <span class="text-xs text-amber-500 italic">Belum Lengkap</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-12 px-6 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <i class='bx bx-folder-open text-5xl text-gray-300 mb-3'></i>
                                        <p class="text-gray-500 text-lg font-medium">Belum Ada Data Nilai</p>
                                        <p class="text-gray-400 text-sm">Nilai untuk semester ini belum diinput oleh
                                            Bapak/Ibu Guru.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>
