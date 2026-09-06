<x-app-layout>
    <x-slot name="header">Dashboard Admin Tata Usaha</x-slot>

    <!-- Ringkasan Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center gap-5">
            <div
                class="w-14 h-14 bg-blue-100 text-[#1E3A8A] rounded-xl flex items-center justify-center text-3xl shrink-0">
                <i class='bx bx-user'></i></div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Total Siswa Aktif</p>
                <h3 class="text-2xl font-bold text-gray-900">{{ number_format($totalSiswa) }}</h3>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center gap-5">
            <div
                class="w-14 h-14 bg-amber-100 text-amber-600 rounded-xl flex items-center justify-center text-3xl shrink-0">
                <i class='bx bx-briefcase'></i></div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Total Guru</p>
                <h3 class="text-2xl font-bold text-gray-900">{{ number_format($totalGuru) }}</h3>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center gap-5">
            <div
                class="w-14 h-14 bg-green-100 text-green-600 rounded-xl flex items-center justify-center text-3xl shrink-0">
                <i class='bx bx-building-house'></i></div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Jumlah Kelas</p>
                <h3 class="text-2xl font-bold text-gray-900">{{ number_format($totalKelas) }}</h3>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center gap-5">
            <div
                class="w-14 h-14 bg-purple-100 text-purple-600 rounded-xl flex items-center justify-center text-3xl shrink-0">
                <i class='bx bx-file'></i></div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Pendaftar PPDB</p>
                <h3 class="text-2xl font-bold text-gray-900">{{ number_format($totalPPDB) }}</h3>
            </div>
        </div>
    </div>

    <!-- Area Tabel Cepat -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-white">
            <h4 class="font-bold text-gray-800 text-lg">Pendaftar PPDB Terbaru (Menunggu Verifikasi)</h4>
            <a href="{{ route('admin.ppdb.index') }}" class="text-sm text-[#1E3A8A] font-medium hover:underline">Lihat
                Semua</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 text-sm">
                        <th class="py-3 px-6 font-medium">No. Daftar</th>
                        <th class="py-3 px-6 font-medium">Nama Calon Siswa</th>
                        <th class="py-3 px-6 font-medium">Asal Sekolah</th>
                        <th class="py-3 px-6 font-medium">Status</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-sm">
                    @forelse($pendaftarTerbaru as $pendaftar)
                        <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                            <td class="py-4 px-6 font-medium font-mono text-gray-900">
                                {{ $pendaftar->nomor_pendaftaran }}</td>
                            <td class="py-4 px-6">{{ $pendaftar->nama_lengkap }}</td>
                            <td class="py-4 px-6">{{ $pendaftar->asal_sekolah }}</td>
                            <td class="py-4 px-6"><span
                                    class="px-3 py-1 bg-amber-100 text-amber-700 rounded-full text-xs font-semibold">{{ $pendaftar->status }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-6 px-6 text-center text-gray-500">Tidak ada pendaftar yang
                                menunggu verifikasi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
