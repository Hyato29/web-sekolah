<x-app-layout>
    <x-slot name="header">
        Input & Kelola Nilai Akademik
    </x-slot>

    <div class="space-y-6">

        <!-- Notifikasi -->
        @if (session('success'))
            <div
                class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative flex items-center gap-2">
                <i class='bx bx-check-circle text-xl'></i>
                <span class="block sm:inline font-medium">{{ session('success') }}</span>
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

        <!-- Form Filter & Pemilihan (Step 1) -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4 border-b border-gray-100 pb-3">Langkah 1: Pilih Parameter
                Penilaian</h3>

            <!-- Gunakan GET form agar URL memiliki parameter kelas_id -->
            <form method="GET" action="{{ route('guru.nilai.index') }}"
                class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                <div class="col-span-1 md:col-span-3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Kelas</label>
                    <select name="kelas_id" required
                        class="w-full rounded-lg border-gray-300 py-2.5 px-3 border focus:ring-[#1E3A8A] text-sm">
                        <option value="">-- Pilih Kelas --</option>
                        @foreach ($kelas as $k)
                            <option value="{{ $k->id }}" {{ $selectedKelas == $k->id ? 'selected' : '' }}>
                                {{ $k->nama_kelas }} ({{ $k->tahun_ajaran }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <button type="submit"
                        class="w-full bg-amber-400 hover:bg-amber-500 text-gray-900 font-bold px-4 py-2.5 rounded-lg transition">
                        Tampilkan Siswa
                    </button>
                </div>
            </form>
        </div>

        <!-- Area Input Massal (Step 2) -->
        @if ($selectedKelas && $siswa->count() > 0)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-800">Langkah 2: Input Nilai Kelas</h3>
                    <span
                        class="bg-blue-100 text-[#1E3A8A] px-3 py-1 rounded-full text-xs font-bold">{{ $siswa->count() }}
                        Siswa</span>
                </div>

                <form method="POST" action="{{ route('guru.nilai.store') }}" class="p-0">
                    @csrf
                    <input type="hidden" name="kelas_id" value="{{ $selectedKelas }}">

                    <!-- Pengaturan Form Atas -->
                    <div class="p-6 grid grid-cols-1 md:grid-cols-4 gap-4 border-b border-gray-100 bg-white">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Mata Pelajaran</label>
                            <select name="mapel_id" required
                                class="w-full rounded-lg border-gray-300 py-2 px-3 border text-sm">
                                <option value="">-- Pilih Mapel --</option>
                                @foreach ($mapel as $m)
                                    <option value="{{ $m->id }}">{{ $m->nama_mapel }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Jenis Penilaian</label>
                            <select name="jenis_nilai" required
                                class="w-full rounded-lg border-gray-300 py-2 px-3 border text-sm">
                                <option value="Tugas">Tugas Harian</option>
                                <option value="UTS">Ujian Tengah Semester (UTS)</option>
                                <option value="UAS">Ujian Akhir Semester (UAS)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Semester</label>
                            <select name="semester" required
                                class="w-full rounded-lg border-gray-300 py-2 px-3 border text-sm">
                                <option value="1">1 (Ganjil)</option>
                                <option value="2">2 (Genap)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Tahun Ajaran</label>
                            <!-- Biasanya ambil dinamis dari tabel konfigurasi, ini contoh statis -->
                            <input type="text" name="tahun_ajaran" value="2026/2027" required readonly
                                class="w-full rounded-lg bg-gray-100 border-gray-300 py-2 px-3 border text-sm text-gray-600">
                        </div>
                    </div>

                    <!-- Tabel Input Siswa -->
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 text-gray-500 text-sm border-b border-gray-200">
                                    <th class="py-3 px-6 font-semibold w-16 text-center">No</th>
                                    <th class="py-3 px-6 font-semibold w-40">NISN</th>
                                    <th class="py-3 px-6 font-semibold">Nama Lengkap</th>
                                    <th class="py-3 px-6 font-semibold w-48 text-center">Input Nilai (0-100)</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-700 text-sm">
                                @foreach ($siswa as $index => $item)
                                    <tr class="border-b border-gray-50 hover:bg-blue-50/30 transition">
                                        <td class="py-3 px-6 text-center text-gray-500">{{ $loop->iteration }}</td>
                                        <td class="py-3 px-6 font-mono text-gray-600">{{ $item->nisn }}</td>
                                        <td class="py-3 px-6 font-bold text-gray-900">
                                            {{ $item->user->name ?? 'Tanpa Nama' }}</td>
                                        <td class="py-3 px-6 text-center">
                                            <!-- Input array dengan key siswa_id -->
                                            <input type="number" step="0.01" name="nilai[{{ $item->id }}]"
                                                min="0" max="100"
                                                class="w-24 text-center rounded-lg border-gray-300 py-1.5 px-3 border focus:ring-[#1E3A8A] focus:border-[#1E3A8A] text-sm font-bold"
                                                placeholder="0 - 100">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Footer Tombol -->
                    <div class="p-6 bg-gray-50 border-t border-gray-100 flex justify-end gap-3">
                        <a href="{{ route('guru.nilai.index') }}"
                            class="rounded-lg bg-white px-6 py-2.5 text-sm font-medium text-gray-700 border border-gray-300 hover:bg-gray-50 transition">Batal
                            / Reset</a>
                        <button type="submit"
                            class="rounded-lg bg-[#1E3A8A] px-8 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-blue-800 transition flex items-center gap-2">
                            <i class='bx bx-save text-lg'></i> Simpan Seluruh Nilai
                        </button>
                    </div>
                </form>
            </div>
        @elseif($selectedKelas)
            <!-- Jika kelas dipilih tapi tidak ada siswanya -->
            <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 rounded-2xl p-8 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-yellow-100 mb-4">
                    <i class='bx bx-group text-3xl'></i>
                </div>
                <h4 class="text-lg font-bold mb-2">Kelas Belum Memiliki Siswa</h4>
                <p class="text-sm">Silakan hubungi Admin TU untuk menambahkan siswa ke dalam kelas ini sebelum menginput
                    nilai.</p>
            </div>
        @endif

    </div>
</x-app-layout>
