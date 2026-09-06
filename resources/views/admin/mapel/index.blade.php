<x-app-layout>
    <x-slot name="header">Data Master Mata Pelajaran</x-slot>

    <div x-data="{ openModal: false, editMode: false, modalData: { id: '', kode_mapel: '', nama_mapel: '' } }">

        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-xl font-bold text-gray-800">Daftar Mata Pelajaran</h2>
                <p class="text-sm text-gray-500">Kelola mata pelajaran yang diajarkan di sekolah.</p>
            </div>
            <button @click="openModal = true; editMode = false; modalData = { id: '', kode_mapel: '', nama_mapel: '' }"
                class="bg-[#1E3A8A] hover:bg-blue-800 text-white px-4 py-2 rounded-lg font-medium transition shadow-sm flex items-center gap-2">
                <i class='bx bx-plus text-xl'></i> Tambah Mapel
            </button>
        </div>

        @if (session('success'))
            <div
                class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative mb-4 flex items-center gap-2">
                <i class='bx bx-check-circle text-xl'></i> <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative mb-4">
                <ul class="list-disc list-inside text-sm font-medium">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Tabel Data -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-gray-500 text-sm border-b border-gray-100">
                            <th class="py-4 px-6 font-semibold w-16">No</th>
                            <th class="py-4 px-6 font-semibold w-48">Kode Mapel</th>
                            <th class="py-4 px-6 font-semibold">Nama Mata Pelajaran</th>
                            <th class="py-4 px-6 font-semibold text-center w-32">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 text-sm">
                        @forelse($mapel as $index => $item)
                            <tr class="border-b border-gray-50 hover:bg-blue-50/50 transition">
                                <td class="py-4 px-6 text-gray-500">{{ $mapel->firstItem() + $index }}</td>
                                <td class="py-4 px-6 font-mono font-bold text-gray-600">{{ $item->kode_mapel }}</td>
                                <td class="py-4 px-6 font-bold text-gray-900">{{ $item->nama_mapel }}</td>
                                <td class="py-4 px-6 text-center space-x-2 flex justify-center">
                                    <button
                                        @click="openModal = true; editMode = true; modalData = { id: '{{ $item->id }}', kode_mapel: '{{ $item->kode_mapel }}', nama_mapel: '{{ $item->nama_mapel }}' }"
                                        class="w-8 h-8 rounded-lg bg-amber-100 text-amber-600 hover:bg-amber-500 hover:text-white flex items-center justify-center transition">
                                        <i class='bx bx-edit text-lg'></i>
                                    </button>

                                    <form action="{{ route('admin.mata-pelajaran.destroy', $item->id) }}" method="POST"
                                        class="inline-block"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus mapel ini?');">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="w-8 h-8 rounded-lg bg-red-100 text-red-600 hover:bg-red-500 hover:text-white flex items-center justify-center transition">
                                            <i class='bx bx-trash text-lg'></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-8 text-center text-gray-500">Belum ada data mata pelajaran.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($mapel->hasPages())
                <div class="px-6 py-4 border-t border-gray-100 bg-white">
                    {{ $mapel->links() }}
                </div>
            @endif
        </div>

        <!-- Modal Tambah/Edit -->
        <div x-show="openModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div x-show="openModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity"></div>
            <div class="flex min-h-screen items-center justify-center p-4">
                <div x-show="openModal" @click.away="openModal = false"
                    class="relative bg-white rounded-2xl shadow-xl w-full max-w-lg overflow-hidden">
                    <form
                        :action="editMode ? '{{ url('admin/mata-pelajaran') }}/' + modalData.id :
                            '{{ route('admin.mata-pelajaran.store') }}'"
                        method="POST">
                        @csrf
                        <template x-if="editMode"><input type="hidden" name="_method" value="PUT"></template>

                        <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center">
                            <h3 class="text-xl font-bold text-gray-900"
                                x-text="editMode ? 'Edit Mata Pelajaran' : 'Tambah Mapel Baru'"></h3>
                            <button type="button" @click="openModal = false"
                                class="text-gray-400 hover:text-gray-500"><i class='bx bx-x text-2xl'></i></button>
                        </div>

                        <div class="p-6 space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Kode Mapel</label>
                                <input type="text" name="kode_mapel" x-model="modalData.kode_mapel" required
                                    class="block w-full rounded-lg border-gray-300 py-2.5 px-3 border focus:ring-[#1E3A8A]"
                                    placeholder="Contoh: MTK-WJB">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Mata Pelajaran</label>
                                <input type="text" name="nama_mapel" x-model="modalData.nama_mapel" required
                                    class="block w-full rounded-lg border-gray-300 py-2.5 px-3 border focus:ring-[#1E3A8A]"
                                    placeholder="Contoh: Matematika Wajib">
                            </div>
                        </div>

                        <div class="bg-gray-50 px-6 py-4 flex flex-row-reverse gap-3 border-t border-gray-100">
                            <button type="submit"
                                class="bg-[#1E3A8A] text-white px-5 py-2.5 rounded-lg font-bold hover:bg-blue-800 transition">Simpan
                                Data</button>
                            <button type="button" @click="openModal = false"
                                class="bg-white border text-gray-700 px-5 py-2.5 rounded-lg font-medium hover:bg-gray-50 transition">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
