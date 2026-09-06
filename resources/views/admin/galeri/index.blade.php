<x-app-layout>
    <x-slot name="header">Galeri Sekolah</x-slot>

    <div x-data="{ openModal: false }" class="space-y-6">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-xl font-bold text-gray-800">Dokumentasi Kegiatan</h2>
                <p class="text-sm text-gray-500">Kelola foto yang akan tampil di halaman depan.</p>
            </div>
            <button @click="openModal = true"
                class="bg-[#1E3A8A] text-white px-4 py-2 rounded-lg font-medium shadow-sm flex items-center gap-2">
                <i class='bx bx-upload text-xl'></i> Upload Foto
            </button>
        </div>

        @if (session('success'))
            <div class="bg-green-100 text-green-700 px-4 py-3 rounded-lg"><i class='bx bx-check-circle'></i>
                {{ session('success') }}</div>
        @endif

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @forelse($galeri as $item)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden group">
                    <img src="{{ Storage::url($item->foto) }}" alt="{{ $item->judul }}"
                        class="w-full h-40 object-cover group-hover:scale-105 transition duration-300">
                    <div class="p-3">
                        <h4 class="font-bold text-sm text-gray-900 truncate">{{ $item->judul }}</h4>
                        <p class="text-xs text-gray-500 truncate mb-2">{{ $item->keterangan ?? '-' }}</p>
                        <form action="{{ route('admin.galeri.destroy', $item->id) }}" method="POST"
                            onsubmit="return confirm('Hapus foto ini?');">
                            @csrf @method('DELETE')
                            <button type="submit"
                                class="w-full bg-red-50 text-red-600 hover:bg-red-500 hover:text-white py-1.5 rounded-lg text-xs font-bold transition">Hapus</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-10 text-center text-gray-500">Belum ada foto di galeri.</div>
            @endforelse
        </div>
        {{ $galeri->links() }}

        <!-- Modal -->
        <div x-show="openModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4"
            style="display:none;">
            <div @click.away="openModal = false" class="bg-white rounded-2xl w-full max-w-md overflow-hidden">
                <form action="{{ route('admin.galeri.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="p-5 border-b font-bold text-lg">Upload Foto Baru</div>
                    <div class="p-5 space-y-4">
                        <div><label class="block text-sm font-bold mb-1">Judul Foto</label><input type="text"
                                name="judul" required class="w-full border-gray-300 rounded-lg"></div>
                        <div><label class="block text-sm font-bold mb-1">Keterangan Singkat</label><input type="text"
                                name="keterangan" class="w-full border-gray-300 rounded-lg"></div>
                        <div><label class="block text-sm font-bold mb-1">Pilih File Foto</label><input type="file"
                                name="foto" required accept="image/*"
                                class="w-full border-gray-300 border p-2 rounded-lg"></div>
                    </div>
                    <div class="p-4 bg-gray-50 flex justify-end gap-2">
                        <button type="button" @click="openModal = false"
                            class="px-4 py-2 border rounded-lg">Batal</button>
                        <button type="submit"
                            class="bg-[#1E3A8A] text-white px-4 py-2 rounded-lg font-bold">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
