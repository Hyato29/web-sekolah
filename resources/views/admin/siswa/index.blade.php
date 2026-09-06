<x-app-layout>
    <x-slot name="header">
        Manajemen Akun Siswa
    </x-slot>

    <div x-data="{ openModal: false }">
        
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-xl font-bold text-gray-800">Daftar Siswa</h2>
                <p class="text-sm text-gray-500">Kelola akun akses dan profil siswa aktif.</p>
            </div>
            <button @click="openModal = true" class="bg-[#1E3A8A] hover:bg-blue-800 text-white px-4 py-2 rounded-lg font-medium transition flex items-center gap-2">
                <i class='bx bx-user-plus text-xl'></i> Tambah Siswa
            </button>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative mb-4 flex items-center gap-2">
                <i class='bx bx-check-circle text-xl'></i>
                <span class="block sm:inline font-medium">{{ session('success') }}</span>
            </div>
        @endif
        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative mb-4">
                <ul class="list-disc list-inside text-sm font-medium">
                    @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                </ul>
            </div>
        @endif

        <!-- Tabel Siswa -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-gray-500 text-sm border-b border-gray-100">
                            <th class="py-4 px-6 font-semibold w-16">No</th>
                            <th class="py-4 px-6 font-semibold">NISN</th>
                            <th class="py-4 px-6 font-semibold">Nama Lengkap</th>
                            <th class="py-4 px-6 font-semibold">Kelas</th>
                            <th class="py-4 px-6 font-semibold">Email Login</th>
                            <th class="py-4 px-6 font-semibold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 text-sm">
                        @forelse($siswa as $index => $item)
                        <tr class="border-b border-gray-50 hover:bg-blue-50/50 transition">
                            <td class="py-4 px-6 text-gray-500">{{ $siswa->firstItem() + $index }}</td>
                            <td class="py-4 px-6 font-medium font-mono text-gray-600">{{ $item->nisn }}</td>
                            <td class="py-4 px-6 font-bold text-gray-900">{{ $item->user->name }}</td>
                            <td class="py-4 px-6"><span class="px-3 py-1 bg-amber-100 text-amber-700 rounded-full text-xs font-semibold">{{ $item->kelas->nama_kelas ?? '-' }}</span></td>
                            <td class="py-4 px-6">{{ $item->user->email }}</td>
                            <td class="py-4 px-6 text-center space-x-2 flex justify-center">
                                <form action="{{ route('admin.siswa.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus siswa ini beserta akses loginnya secara permanen?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="w-8 h-8 rounded-lg bg-red-100 text-red-600 hover:bg-red-500 hover:text-white flex items-center justify-center transition">
                                        <i class='bx bx-trash text-lg'></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-8 px-6 text-center text-gray-500">Belum ada data siswa.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($siswa->hasPages())
                <div class="px-6 py-4 border-t border-gray-100 bg-white">
                    {{ $siswa->links() }}
                </div>
            @endif
        </div>

        <!-- Modal Tambah Siswa -->
        <div x-show="openModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div x-show="openModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity"></div>

            <div class="flex min-h-screen items-center justify-center p-4">
                <div x-show="openModal" @click.away="openModal = false" class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:w-full sm:max-w-2xl">
                    <form action="{{ route('admin.siswa.store') }}" method="POST">
                        @csrf
                        <div class="bg-white px-6 py-5 border-b border-gray-100 flex justify-between items-center">
                            <h3 class="text-xl font-bold text-gray-900">Pendaftaran Akun Siswa Baru</h3>
                            <button type="button" @click="openModal = false" class="text-gray-400 hover:text-gray-500"><i class='bx bx-x text-2xl'></i></button>
                        </div>
                        
                        <div class="px-6 py-5 grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Kolom Data Login -->
                            <div class="col-span-1 space-y-4">
                                <h4 class="text-sm font-semibold text-[#1E3A8A] uppercase tracking-wider mb-2">Data Login</h4>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Email Akses</label>
                                    <input type="email" name="email" required class="w-full rounded-lg border-gray-300 py-2 px-3 border focus:ring-[#1E3A8A] focus:border-[#1E3A8A] text-sm" placeholder="siswa@sekolah.com">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Kata Sandi Akses</label>
                                    <input type="password" name="password" required class="w-full rounded-lg border-gray-300 py-2 px-3 border focus:ring-[#1E3A8A] focus:border-[#1E3A8A] text-sm" placeholder="Minimal 8 karakter">
                                </div>
                            </div>

                            <!-- Kolom Profil Akademik -->
                            <div class="col-span-1 space-y-4 md:border-l md:border-gray-100 md:pl-4">
                                <h4 class="text-sm font-semibold text-[#1E3A8A] uppercase tracking-wider mb-2">Profil Akademik</h4>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">NISN</label>
                                    <input type="text" name="nisn" required class="w-full rounded-lg border-gray-300 py-2 px-3 border focus:ring-[#1E3A8A] text-sm" placeholder="Nomor Induk Siswa Nasional">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap Siswa</label>
                                    <input type="text" name="nama" required class="w-full rounded-lg border-gray-300 py-2 px-3 border focus:ring-[#1E3A8A] text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Penempatan Kelas</label>
                                    <select name="kelas_id" required class="w-full rounded-lg border-gray-300 py-2 px-3 border focus:ring-[#1E3A8A] text-sm">
                                        <option value="">-- Pilih Kelas --</option>
                                        @foreach($kelas as $k)
                                            <option value="{{ $k->id }}">{{ $k->nama_kelas }} ({{ $k->tahun_ajaran }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Baris Alamat (Membentang 2 Kolom) -->
                            <div class="col-span-1 md:col-span-2 mt-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Tempat Tinggal (Opsional)</label>
                                <textarea name="alamat" rows="2" class="w-full rounded-lg border-gray-300 py-2 px-3 border focus:ring-[#1E3A8A] focus:border-[#1E3A8A] text-sm" placeholder="Masukkan alamat lengkap..."></textarea>
                            </div>
                        </div>

                        <div class="bg-gray-50 px-6 py-4 flex flex-row-reverse gap-3 border-t border-gray-100">
                            <button type="submit" class="rounded-lg bg-[#1E3A8A] px-5 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-blue-800 transition">Buat Akun</button>
                            <button type="button" @click="openModal = false" class="rounded-lg bg-white px-5 py-2.5 text-sm font-medium text-gray-700 border border-gray-300 hover:bg-gray-50 transition">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>