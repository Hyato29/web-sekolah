<x-app-layout>
    <x-slot name="header">Jadwal Pelajaran Mingguan</x-slot>

    <div class="mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Kelas {{ $siswa->kelas->nama_kelas ?? '-' }}</h2>
            <p class="text-gray-500 text-sm">Tahun Ajaran {{ $siswa->kelas->tahun_ajaran ?? '-' }}</p>
        </div>
        <button onclick="window.print()"
            class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg font-medium hover:bg-gray-50 transition flex items-center gap-2 shadow-sm">
            <i class='bx bx-printer text-lg'></i> Cetak Jadwal
        </button>
    </div>

    <!-- Grid Hari (Senin - Sabtu) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @php
            $hariOrder = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        @endphp

        @foreach ($hariOrder as $hari)
            <div
                class="bg-white rounded-2xl shadow-sm border {{ date('N') == array_search($hari, $hariOrder) + 1 ? 'border-amber-400 ring-4 ring-amber-50' : 'border-gray-100' }} overflow-hidden">
                <div
                    class="px-5 py-3 border-b border-gray-100 flex justify-between items-center {{ date('N') == array_search($hari, $hariOrder) + 1 ? 'bg-amber-400 text-gray-900' : 'bg-gray-50 text-gray-800' }}">
                    <h3 class="font-bold text-lg">{{ $hari }}</h3>
                    @if (date('N') == array_search($hari, $hariOrder) + 1)
                        <span class="text-xs font-bold uppercase bg-white/50 px-2 py-1 rounded-md">Hari Ini</span>
                    @endif
                </div>

                <div class="p-0">
                    @if (isset($jadwalPerHari[$hari]))
                        <ul class="divide-y divide-gray-50">
                            @foreach ($jadwalPerHari[$hari] as $item)
                                <li class="p-4 hover:bg-blue-50/50 transition">
                                    <div class="flex gap-4">
                                        <div class="text-center shrink-0 w-16">
                                            <p class="text-sm font-bold text-[#1E3A8A]">
                                                {{ substr($item->jam_mulai, 0, 5) }}</p>
                                            <p class="text-xs text-gray-400">{{ substr($item->jam_selesai, 0, 5) }}</p>
                                        </div>
                                        <div class="border-l-2 border-[#1E3A8A] pl-4">
                                            <h4 class="font-bold text-gray-900 leading-tight">
                                                {{ $item->mapel->nama_mapel }}</h4>
                                            <p class="text-sm text-gray-500 mt-0.5"><i class='bx bx-user text-xs'></i>
                                                {{ $item->guru->user->name }}</p>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="p-8 text-center text-gray-400">
                            <i class='bx bx-coffee text-3xl mb-2 text-gray-300'></i>
                            <p class="text-sm">Tidak ada jadwal</p>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</x-app-layout>
