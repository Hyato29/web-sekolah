<x-app-layout>
    <x-slot name="header">Verifikasi Data PPDB</x-slot>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 bg-gray-50">
            <h3 class="text-lg font-bold text-gray-800">Daftar Pendaftar Calon Siswa Baru</h3>
        </div>

        @if (session('success'))
            <div class="m-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 text-sm border-b border-gray-100">
                        <th class="py-3 px-6 font-semibold">No. Pendaftaran</th>
                        <th class="py-3 px-6 font-semibold">Nama Calon Siswa</th>
                        <th class="py-3 px-6 font-semibold">Asal Sekolah</th>
                        <th class="py-3 px-6 font-semibold text-center">Berkas</th>
                        <th class="py-3 px-6 font-semibold text-center">Status</th>
                        <th class="py-3 px-6 font-semibold text-center">Aksi Verifikasi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-sm">
                    @forelse($pendaftar as $item)
                        <tr class="border-b border-gray-50 hover:bg-blue-50/30 transition">
                            <td class="py-4 px-6 font-mono font-bold text-gray-900">{{ $item->nomor_pendaftaran }}</td>
                            <td class="py-4 px-6">
                                <p class="font-bold text-gray-900">{{ $item->nama_lengkap }}</p>
                                <p class="text-xs text-gray-500">Wali: {{ $item->nama_orang_tua }}
                                    ({{ $item->nomor_telepon }})</p>
                            </td>
                            <td class="py-4 px-6">{{ $item->asal_sekolah }}</td>
                            <td class="py-4 px-6 text-center">
                                @if ($item->berkas_dokumen)
                                    <a href="{{ Storage::url($item->berkas_dokumen) }}" target="_blank"
                                        class="text-[#1E3A8A] hover:underline flex items-center justify-center gap-1">
                                        <i class='bx bx-file text-lg'></i> Lihat
                                    </a>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-center">
                                @php
                                    $badgeClass = match ($item->status) {
                                        'Diterima' => 'bg-green-100 text-green-700',
                                        'Ditolak' => 'bg-red-100 text-red-700',
                                        'Revisi' => 'bg-blue-100 text-blue-700',
                                        default => 'bg-amber-100 text-amber-700',
                                    };
                                @endphp
                                <span
                                    class="px-3 py-1 rounded-full text-xs font-bold {{ $badgeClass }}">{{ $item->status }}</span>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <form action="{{ route('admin.ppdb.update_status', $item->id) }}" method="POST"
                                    class="flex gap-2 justify-center">
                                    @csrf
                                    <select name="status"
                                        class="text-xs border-gray-300 rounded-lg py-1 px-2 focus:ring-[#1E3A8A]"
                                        onchange="this.form.submit()">
                                        <option value="Menunggu" {{ $item->status == 'Menunggu' ? 'selected' : '' }}>
                                            Menunggu</option>
                                        <option value="Diterima" {{ $item->status == 'Diterima' ? 'selected' : '' }}>
                                            Diterima</option>
                                        <option value="Revisi" {{ $item->status == 'Revisi' ? 'selected' : '' }}>Perlu
                                            Revisi</option>
                                        <option value="Ditolak" {{ $item->status == 'Ditolak' ? 'selected' : '' }}>
                                            Ditolak</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-gray-500">Belum ada pendaftar masuk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-100 bg-white">{{ $pendaftar->links() }}</div>
    </div>
</x-app-layout>
