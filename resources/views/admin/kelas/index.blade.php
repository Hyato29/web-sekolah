<x-app-layout>
    <x-slot name="header">
        Manajemen Data Kelas
    </x-slot>

    <div x-data="{ openModal: false, editMode: false, modalData: { id: '', nama_kelas: '', tahun_ajaran: '' } }">
        
        <!-- Header & Action -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-xl font-bold text-gray-800">Daftar Kelas</h2>
                <p class="text-sm text-gray-500">Kelola data master kelas dan tahun ajaran aktif.</p>
            </div>
            <button @click="openModal = true; editMode = false; modalData = { id: '', nama_kelas: '', tahun_ajaran: '2026/2027' }" 
                    class="bg-[#1E3A8A] hover:bg-blue-800 text-white px-4 py-2 rounded-lg font-medium transition shadow-sm flex items-center gap-2">
                <i class='bx bx-plus text-xl'></i> Tambah Kelas
            </button>
        </div>

        <!-- Notifikasi -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative mb-4 flex items-center gap-2">
                <i class='bx bx-check-circle text-xl'></i>
                <span class="block sm:inline font-medium">{{ session('success') }}</span>
            </div>
        @endif
        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative mb-4">
                <ul class="list-disc list-inside text-sm font-medium">
                    @foreach($errors->all() as $error)
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
                            <th class="py-4 px-6 font-semibold">Nama Kelas</th>
                            <th class="py-4 px-6 font-semibold">Tahun Ajaran</th>
                            <th class="py-4 px-6 font-semibold text-center w-32">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 text-sm">
                        @forelse($kelas as $index => $item)
                        <tr class="border-b border-gray-50 hover:bg-blue-50/50 transition">
                            <td class="py-4 px-6 text-gray-500">{{ $kelas->firstItem() + $index }}</td>
                            <td class="py-4 px-6 font-bold text-gray-900">{{ $item->nama_kelas }}</td>
                            <td class="py-4 px-6"><span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-xs font-semibold">{{ $item->tahun_ajaran }}</span></td>
                            <td class="py-4 px-6 text-center space-x-2 flex justify-center">
                                <!-- Tombol Edit -->
                                <button @click="openModal = true; editMode = true; modalData = { id: '{{ $item->id }}', nama_kelas: '{{ $item->nama_kelas }}', tahun_ajaran: '{{ $item->tahun_ajaran }}' }" 
                                        class="w-8 h-8 rounded-lg bg-amber-100 text-amber-600 hover:bg-amber-500 hover:text-white flex items-center justify-center transition">
                                    <i class='bx bx-edit text-lg'></i>
                                </button>
                                
                                <!-- Tombol Delete -->
                                <form action="{{ route('admin.kelas.destroy', $item->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kelas ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-8 h-8 rounded-lg bg-red-100 text-red-600 hover:bg-red-500 hover:text-white flex items-center justify-center transition">
                                        <i class='bx bx-trash text-lg'></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="py-8 px-6 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center">
                                    <i class='bx bx-folder-open text-4xl text-gray-300 mb-2'></i>
                                    <p>Belum ada data kelas yang ditambahkan.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            @if($kelas->hasPages())
                <div class="px-6 py-4 border-t border-gray-100 bg-white">
                    {{ $kelas->links() }}
                </div>
            @endif
        </div>

        <!-- Modal Tambah/Edit Menggunakan Alpine.js -->
        <div x-show="openModal" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true" style="display: none;">
            <!-- Overlay -->
            <div x-show="openModal" x-transition.opacity class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity"></div>

            <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
                <!-- Modal Panel -->
                <div x-show="openModal" 
                     x-transition:enter="ease-out duration-300" 
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                     x-transition:leave="ease-in duration-200" 
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                    
                    <form :action="editMode ? '{{ url('admin/kelas') }}/' + modalData.id : '{{ route('admin.kelas.store') }}'" method="POST">
                        @csrf
                        <!-- Method spoofing for update -->
                        <template x-if="editMode">
                            <input type="hidden" name="_method" value="PUT">
                        </template>

                        <div class="bg-white px-6 pb-6 pt-5 sm:p-8">
                            <div class="flex justify-between items-center mb-5">
                                <h3 class="text-xl font-bold leading-6 text-gray-900" id="modal-title" x-text="editMode ? 'Edit Data Kelas' : 'Tambah Kelas Baru'"></h3>
                                <button type="button" @click="openModal = false" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                                    <i class='bx bx-x text-2xl'></i>
                                </button>
                            </div>
                            
                            <div class="space-y-4">
                                <div>
                                    <label for="nama_kelas" class="block text-sm font-medium text-gray-700 mb-1">Nama Kelas</label>
                                    <input type="text" name="nama_kelas" id="nama_kelas" x-model="modalData.nama_kelas" required class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm py-2.5 px-3 border" placeholder="Contoh: XII MIPA 1">
                                </div>
                                <div>
                                    <label for="tahun_ajaran" class="block text-sm font-medium text-gray-700 mb-1">Tahun Ajaran</label>
                                    <input type="text" name="tahun_ajaran" id="tahun_ajaran" x-model="modalData.tahun_ajaran" required class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm py-2.5 px-3 border" placeholder="Contoh: 2026/2027">
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-6 py-4 sm:flex sm:flex-row-reverse sm:px-8 border-t border-gray-100 gap-3">
                            <button type="submit" class="w-full sm:w-auto inline-flex justify-center rounded-lg bg-[#1E3A8A] px-5 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-blue-800 transition">
                                Simpan Data
                            </button>
                            <button type="button" @click="openModal = false" class="mt-3 w-full sm:w-auto inline-flex justify-center rounded-lg bg-white px-5 py-2.5 text-sm font-medium text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 transition sm:mt-0">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>