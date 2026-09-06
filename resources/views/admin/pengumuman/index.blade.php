<x-app-layout>
    <x-slot name="header">
        Papan Pengumuman Sekolah
    </x-slot>

    <div x-data="{ openModal: false, editMode: false, modalData: { id: '', judul: '', isi: '', kategori: 'Informasi Umum', kelas_id: '', tanggal_publish: '{{ now()->format('Y-m-d\TH:i') }}' } }">

        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-xl font-bold text-gray-800">Daftar Pengumuman</h2>
                <p class="text-sm text-gray-500">Kelola informasi publik dan pengumuman khusus kelas.</p>
            </div>
            <button
                @click="openModal = true; editMode = false; modalData = { id: '', judul: '', isi: '', kategori: 'Informasi Umum', kelas_id: '', tanggal_publish: '{{ now()->format('Y-m-d\TH:i') }}' }"
                class="bg-[#1E3A8A] hover:bg-blue-800 text-white px-4 py-2 rounded-lg font-medium transition flex items-center gap-2">
                <i class='bx bx-plus-circle text-xl'></i> Buat Pengumuman
            </button>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative mb-4">
                <span class="block sm:inline font-medium">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Daftar Pengumuman -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($pengumuman as $item)
                <div
                    class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col hover:shadow-md transition">
                    <div class="p-5 flex-1 border-b border-gray-50">
                        <div class="flex justify-between items-start mb-3">
                            <span
                                class="px-2.5 py-1 rounded-full text-xs font-bold 
                                {{ $item->kategori == 'Penting' ? 'bg-red-100 text-red-700' : ($item->kategori == 'Akademik' ? 'bg-blue-100 text-[#1E3A8A]' : 'bg-amber-100 text-amber-700') }}">
                                {{ $item->kategori }}
                            </span>
                            <div class="flex gap-2">
                                <button
                                    @click="openModal = true; editMode = true; modalData = { id: '{{ $item->id }}', judul: '{{ addslashes($item->judul) }}', isi: '{{ preg_replace('/\r|\n/', '\\n', addslashes($item->isi)) }}', kategori: '{{ $item->kategori }}', kelas_id: '{{ $item->kelas_id }}', tanggal_publish: '{{ $item->tanggal_publish->format('Y-m-d\TH:i') }}' }"
                                    class="text-gray-400 hover:text-amber-500 transition">
                                    <i class='bx bx-edit text-lg'></i>
                                </button>
                                <form action="{{ route('admin.pengumuman.destroy', $item->id) }}" method="POST"
                                    class="inline" onsubmit="return confirm('Hapus pengumuman ini?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-gray-400 hover:text-red-500 transition"><i
                                            class='bx bx-trash text-lg'></i></button>
                                </form>
                            </div>
                        </div>
                        <h3 class="font-bold text-gray-900 text-lg mb-2 leading-tight">{{ $item->judul }}</h3>
                        <p class="text-sm text-gray-600 line-clamp-3 mb-4">{{ $item->isi }}</p>

                        <!-- Indikator Target -->
                        <div class="flex items-center text-xs font-semibold text-gray-500 gap-1 mt-auto">
                            @if ($item->kelas_id)
                                <i class='bx bx-group text-blue-500'></i> Target: Kelas {{ $item->kelas->nama_kelas }}
                            @else
                                <i class='bx bx-globe text-green-500'></i> Target: Publik / Umum
                            @endif
                        </div>
                    </div>
                    <div class="px-5 py-3 bg-gray-50 text-xs text-gray-400 flex justify-between items-center">
                        <span>Oleh: {{ $item->author->name }}</span>
                        <span>{{ $item->tanggal_publish->translatedFormat('d M Y, H:i') }}</span>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white rounded-2xl p-8 text-center border border-gray-100">
                    <i class='bx bx-news text-5xl text-gray-300 mb-3'></i>
                    <p class="text-gray-500">Belum ada pengumuman yang dipublikasikan.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $pengumuman->links() }}
        </div>

        <!-- Modal Buat/Edit -->
        <div x-show="openModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div x-show="openModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm"></div>

            <div class="flex min-h-screen items-center justify-center p-4">
                <div x-show="openModal" @click.away="openModal = false"
                    class="relative bg-white rounded-2xl shadow-xl w-full max-w-2xl overflow-hidden">

                    <form
                        :action="editMode ? '{{ url('admin/pengumuman') }}/' + modalData.id :
                            '{{ route('admin.pengumuman.store') }}'"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        <template x-if="editMode"><input type="hidden" name="_method" value="PUT"></template>

                        <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center">
                            <h3 class="text-xl font-bold text-gray-900"
                                x-text="editMode ? 'Edit Pengumuman' : 'Buat Pengumuman Baru'"></h3>
                            <button type="button" @click="openModal = false"
                                class="text-gray-400 hover:text-gray-500"><i class='bx bx-x text-2xl'></i></button>
                        </div>

                        <div class="p-6 space-y-4">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Judul Pengumuman</label>
                                <input type="text" name="judul" x-model="modalData.judul" required
                                    class="w-full border-gray-300 rounded-lg focus:ring-[#1E3A8A]">
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1">Kategori</label>
                                    <select name="kategori" x-model="modalData.kategori"
                                        class="w-full border-gray-300 rounded-lg focus:ring-[#1E3A8A]">
                                        <option value="Informasi Umum">Informasi Umum</option>
                                        <option value="Akademik">Akademik</option>
                                        <option value="Kegiatan">Kegiatan</option>
                                        <option value="Penting">Penting</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1">Waktu Publikasi</label>
                                    <input type="datetime-local" name="tanggal_publish"
                                        x-model="modalData.tanggal_publish" required
                                        class="w-full border-gray-300 rounded-lg focus:ring-[#1E3A8A]">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Target Audiens (Kosongkan jika
                                    untuk Publik)</label>
                                <select name="kelas_id" x-model="modalData.kelas_id"
                                    class="w-full border-gray-300 rounded-lg focus:ring-[#1E3A8A]">
                                    <option value="">Semua Kelas & Publik (Umum)</option>
                                    @foreach ($kelas as $k)
                                        <option value="{{ $k->id }}">Kelas {{ $k->nama_kelas }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Isi Pengumuman</label>
                                <textarea name="isi" x-model="modalData.isi" rows="5" required
                                    class="w-full border-gray-300 rounded-lg focus:ring-[#1E3A8A]"></textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Upload Gambar
                                    (Opsional)</label>
                                <input type="file" name="gambar" accept="image/*"
                                    class="w-full border-gray-300 rounded-lg p-1.5 border focus:ring-[#1E3A8A]">
                                <p class="text-xs text-gray-500 mt-1" x-show="editMode">Kosongkan jika tidak ingin
                                    mengubah gambar lama.</p>
                            </div>
                        </div>

                        <div class="bg-gray-50 px-6 py-4 flex flex-row-reverse gap-3">
                            <button type="submit"
                                class="bg-[#1E3A8A] hover:bg-blue-800 text-white font-bold py-2.5 px-6 rounded-lg transition">Simpan
                                Pengumuman</button>
                            <button type="button" @click="openModal = false"
                                class="bg-white border border-gray-300 text-gray-700 font-medium py-2.5 px-6 rounded-lg hover:bg-gray-50 transition">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
