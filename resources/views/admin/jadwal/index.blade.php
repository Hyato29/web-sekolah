<x-app-layout>
    <x-slot name="header">Manajemen Jadwal Pelajaran</x-slot>

    <div x-data="{ openModal: false }" class="space-y-6">

        @if (session('success'))
            <div
                class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative flex items-center gap-2">
                <i class='bx bx-check-circle text-xl'></i> <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative">
                <ul class="list-disc list-inside text-sm font-medium">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Filter Kelas -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Filter Berdasarkan Kelas</h3>
                    <p class="text-sm text-gray-500">Pilih kelas untuk melihat atau menambah jadwal pelajaran.</p>
                </div>

                <form method="GET" action="{{ route('admin.jadwal.index') }}" class="flex w-full md:w-auto gap-2">
                    <select name="kelas_id" required
                        class="w-full md:w-64 border-gray-300 rounded-lg focus:ring-[#1E3A8A]">
                        <option value="">-- Pilih Kelas --</option>
                        @foreach ($kelas as $k)
                            <option value="{{ $k->id }}" {{ $selectedKelas == $k->id ? 'selected' : '' }}>Kelas
                                {{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>
                    <button type="submit"
                        class="bg-[#1E3A8A] text-white px-4 py-2 rounded-lg font-bold hover:bg-blue-800 transition">Lihat</button>
                </form>
            </div>
        </div>

        @if ($selectedKelas)
            <!-- Data Jadwal -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                    <h3 class="text-lg font-bold text-gray-800">
                        Jadwal Pelajaran - Kelas {{ $kelas->where('id', $selectedKelas)->first()->nama_kelas ?? '' }}
                    </h3>
                    <button @click="openModal = true"
                        class="bg-amber-400 hover:bg-amber-500 text-gray-900 px-4 py-2 rounded-lg font-bold transition flex items-center gap-2">
                        <i class='bx bx-plus'></i> Tambah Jadwal
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-white text-gray-500 text-sm border-b border-gray-100">
                                <th class="py-3 px-6 font-semibold w-24">Hari</th>
                                <th class="py-3 px-6 font-semibold w-32">Waktu</th>
                                <th class="py-3 px-6 font-semibold">Mata Pelajaran</th>
                                <th class="py-3 px-6 font-semibold">Guru Pengampu</th>
                                <th class="py-3 px-6 font-semibold text-center w-24">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700 text-sm">
                            @php $hariIni = ''; @endphp
                            @forelse($jadwal as $item)
                                <tr class="border-b border-gray-50 hover:bg-blue-50/30 transition">
                                    <td
                                        class="py-3 px-6 font-bold {{ $item->hari != $hariIni ? 'text-[#1E3A8A]' : 'text-transparent' }}">
                                        {{ $item->hari != $hariIni ? $item->hari : '' }}
                                    </td>
                                    <td class="py-3 px-6 font-mono text-gray-500">{{ substr($item->jam_mulai, 0, 5) }} -
                                        {{ substr($item->jam_selesai, 0, 5) }}</td>
                                    <td class="py-3 px-6 font-bold text-gray-900">{{ $item->mapel->nama_mapel }}</td>
                                    <td class="py-3 px-6">{{ $item->guru->user->name }}</td>
                                    <td class="py-3 px-6 text-center">
                                        <form action="{{ route('admin.jadwal.destroy', $item->id) }}" method="POST"
                                            onsubmit="return confirm('Hapus jadwal ini?');">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                class="text-red-500 hover:text-red-700 bg-red-50 p-1.5 rounded-lg"><i
                                                    class='bx bx-trash text-lg'></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @php $hariIni = $item->hari; @endphp
                            @empty
                                <tr>
                                    <td colspan="5" class="py-8 text-center text-gray-500">Jadwal kelas ini belum
                                        diatur.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Modal Tambah Jadwal -->
            <div x-show="openModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
                <div x-show="openModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm"></div>
                <div class="flex min-h-screen items-center justify-center p-4">
                    <div x-show="openModal" @click.away="openModal = false"
                        class="relative bg-white rounded-2xl shadow-xl w-full max-w-lg overflow-hidden">
                        <form action="{{ route('admin.jadwal.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="kelas_id" value="{{ $selectedKelas }}">

                            <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center">
                                <h3 class="text-xl font-bold text-gray-900">Tambah Jadwal Baru</h3>
                                <button type="button" @click="openModal = false"
                                    class="text-gray-400 hover:text-gray-500"><i class='bx bx-x text-2xl'></i></button>
                            </div>

                            <div class="p-6 space-y-4">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1">Mata Pelajaran</label>
                                    <select name="mapel_id" required
                                        class="w-full border-gray-300 rounded-lg focus:ring-[#1E3A8A]">
                                        <option value="">-- Pilih --</option>
                                        @foreach ($mapel as $m)
                                            <option value="{{ $m->id }}">{{ $m->nama_mapel }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1">Guru Pengampu</label>
                                    <select name="guru_id" required
                                        class="w-full border-gray-300 rounded-lg focus:ring-[#1E3A8A]">
                                        <option value="">-- Pilih --</option>
                                        @foreach ($guru as $g)
                                            <option value="{{ $g->id }}">{{ $g->user->name ?? '-' }}
                                                ({{ $g->mapel->nama_mapel ?? '' }})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="grid grid-cols-3 gap-4">
                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 mb-1">Hari</label>
                                        <select name="hari" required
                                            class="w-full border-gray-300 rounded-lg focus:ring-[#1E3A8A]">
                                            <option value="Senin">Senin</option>
                                            <option value="Selasa">Selasa</option>
                                            <option value="Rabu">Rabu</option>
                                            <option value="Kamis">Kamis</option>
                                            <option value="Jumat">Jumat</option>
                                            <option value="Sabtu">Sabtu</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 mb-1">Mulai</label>
                                        <input type="time" name="jam_mulai" required
                                            class="w-full border-gray-300 rounded-lg focus:ring-[#1E3A8A]">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 mb-1">Selesai</label>
                                        <input type="time" name="jam_selesai" required
                                            class="w-full border-gray-300 rounded-lg focus:ring-[#1E3A8A]">
                                    </div>
                                </div>
                            </div>

                            <div class="bg-gray-50 px-6 py-4 flex flex-row-reverse gap-3 border-t border-gray-100">
                                <button type="submit"
                                    class="bg-[#1E3A8A] text-white font-bold py-2.5 px-6 rounded-lg">Simpan</button>
                                <button type="button" @click="openModal = false"
                                    class="bg-white border text-gray-700 py-2.5 px-6 rounded-lg">Batal</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @else
            <div class="bg-blue-50 border border-blue-100 rounded-2xl p-8 text-center mt-4">
                <i class='bx bx-filter text-4xl text-blue-400 mb-2'></i>
                <h4 class="text-lg font-bold text-[#1E3A8A] mb-1">Pilih Kelas Terlebih Dahulu</h4>
                <p class="text-sm text-blue-700">Silakan pilih kelas melalui filter di atas untuk mengelola jadwal
                    pelajaran.</p>
            </div>
        @endif
    </div>
</x-app-layout>
