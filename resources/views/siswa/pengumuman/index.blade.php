<x-app-layout>
    <x-slot name="header">Papan Pengumuman</x-slot>

    <div class="mb-6">
        <h2 class="text-xl font-bold text-gray-800">Informasi & Berita Terbaru</h2>
        <p class="text-sm text-gray-500">Pemberitahuan dari pihak sekolah dan wali kelas Anda.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($pengumuman as $item)
            <div
                class="bg-white rounded-2xl shadow-sm border {{ $item->kategori == 'Penting' ? 'border-red-200 bg-red-50/10' : 'border-gray-100' }} overflow-hidden flex flex-col hover:shadow-md transition">
                <div class="p-6 flex-1 border-b border-gray-50">
                    <div class="flex justify-between items-start mb-4">
                        <span
                            class="px-3 py-1 rounded-full text-xs font-bold 
                            {{ $item->kategori == 'Penting' ? 'bg-red-100 text-red-700' : ($item->kategori == 'Akademik' ? 'bg-blue-100 text-[#1E3A8A]' : 'bg-amber-100 text-amber-700') }}">
                            {{ $item->kategori }}
                        </span>
                        @if ($item->kelas_id)
                            <span class="text-xs font-bold bg-[#1E3A8A] text-white px-2 py-1 rounded-md"
                                title="Khusus untuk kelas Anda"><i class='bx bx-lock-alt'></i> Kelas</span>
                        @endif
                    </div>
                    <h3 class="font-bold text-gray-900 text-lg mb-3 leading-snug">{{ $item->judul }}</h3>
                    <p class="text-sm text-gray-600 whitespace-pre-line line-clamp-4">{{ $item->isi }}</p>
                </div>
                <div class="px-6 py-4 bg-gray-50/50 text-xs text-gray-500 flex justify-between items-center">
                    <span class="flex items-center gap-1"><i class='bx bx-user-circle text-sm'></i>
                        {{ $item->author->name }}</span>
                    <span>{{ $item->tanggal_publish->diffForHumans() }}</span>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white rounded-2xl p-10 text-center border border-gray-100 shadow-sm">
                <i class='bx bx-message-alt-check text-6xl text-gray-300 mb-4'></i>
                <h4 class="text-lg font-bold text-gray-800">Tidak ada pengumuman baru</h4>
                <p class="text-gray-500">Anda sudah membaca semua informasi terbaru.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $pengumuman->links() }}
    </div>
</x-app-layout>
