<x-app-layout>
    <x-slot name="header">Data Siswa Diterima (PPDB)</x-slot>

    <div class="space-y-6">

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-2">
            <div>
                <h2 class="text-xl font-bold text-gray-800">Rekap Calon Siswa Baru</h2>
                <p class="text-sm text-gray-500">Daftar pendaftar yang telah lolos verifikasi dan berstatus Diterima.</p>
            </div>

            <div class="flex gap-2">
                <!-- Fitur Cetak Laporan Sederhana menggunakan JS Print -->
                <button onclick="window.print()"
                    class="bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 px-4 py-2 rounded-lg font-medium transition shadow-sm flex items-center gap-2">
                    <i class='bx bx-printer text-xl'></i> Cetak Laporan
                </button>
                <a href="#"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition shadow-sm flex items-center gap-2">
                    <i class='bx bx-spreadsheet text-xl'></i> Export Excel
                </a>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100 bg-green-50 flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <div
                        class="w-10 h-10 bg-green-100 text-green-600 rounded-full flex items-center justify-center text-xl">
                        <i class='bx bx-user-check'></i>
                    </div>
                    <h3 class="text-lg font-bold text-green-800">Total Diterima: {{ $pendaftar->total() }} Siswa</h3>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-gray-500 text-sm border-b border-gray-100">
                            <th class="py-3 px-6 font-semibold w-16">No</th>
                            <th class="py-3 px-6 font-semibold">No. Pendaftaran</th>
                            <th class="py-3 px-6 font-semibold">Nama Calon Siswa</th>
                            <th class="py-3 px-6 font-semibold">Asal Sekolah</th>
                            <th class="py-3 px-6 font-semibold">Orang Tua / Wali</th>
                            <th class="py-3 px-6 font-semibold">Kontak (WA)</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 text-sm">
                        @forelse($pendaftar as $index => $item)
                            <tr class="border-b border-gray-50 hover:bg-green-50/30 transition">
                                <td class="py-4 px-6 text-gray-500">{{ $pendaftar->firstItem() + $index }}</td>
                                <td class="py-4 px-6 font-mono font-bold text-gray-900">{{ $item->nomor_pendaftaran }}
                                </td>
                                <td class="py-4 px-6 font-bold text-[#1E3A8A]">{{ $item->nama_lengkap }}</td>
                                <td class="py-4 px-6">{{ $item->asal_sekolah }}</td>
                                <td class="py-4 px-6">{{ $item->nama_orang_tua }}</td>
                                <td class="py-4 px-6">
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $item->nomor_telepon) }}"
                                        target="_blank"
                                        class="flex items-center gap-1 text-green-600 hover:text-green-800 font-medium">
                                        <i class='bx bxl-whatsapp text-lg'></i> {{ $item->nomor_telepon }}
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-10 text-center text-gray-500">
                                    <i class='bx bx-folder-open text-5xl text-gray-300 mb-3'></i>
                                    <p>Belum ada siswa yang berstatus Diterima.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($pendaftar->hasPages())
                <div class="px-6 py-4 border-t border-gray-100 bg-white">
                    {{ $pendaftar->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
