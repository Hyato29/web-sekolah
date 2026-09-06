<x-app-layout>
    <x-slot name="header">
        Portal Siswa
    </x-slot>

    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Halo, {{ Auth::user()->name }}! 🎓</h2>
            <p class="text-gray-500 text-sm mt-1">Kelas: XI Rekayasa Perangkat Lunak 1 | NISN: 0012345678</p>
        </div>
    </div>

    <!-- Grid Statistik Siswa -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-center">
            <p class="text-gray-500 text-xs mb-1 font-medium uppercase">Kehadiran Semester</p>
            <h3 class="text-2xl font-bold text-green-600">98%</h3>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-center">
            <p class="text-gray-500 text-xs mb-1 font-medium uppercase">Tugas Pending</p>
            <h3 class="text-2xl font-bold text-red-500">2 <span class="text-sm text-gray-400 font-normal">Tugas</span></h3>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-center">
            <p class="text-gray-500 text-xs mb-1 font-medium uppercase">Nilai Rata-rata</p>
            <h3 class="text-2xl font-bold text-[#1E3A8A]">86.5</h3>
        </div>
        <div class="bg-[#1E3A8A] text-white p-5 rounded-2xl shadow-sm flex flex-col justify-center relative overflow-hidden group cursor-pointer hover:bg-blue-800 transition">
            <p class="text-blue-200 text-xs mb-1 font-medium uppercase">Status Akademik</p>
            <h3 class="text-lg font-bold flex items-center gap-2">Unduh Rapor <i class='bx bx-download text-xl group-hover:translate-y-1 transition'></i></h3>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Jadwal Hari Ini -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i class='bx bx-time-five text-amber-500 text-xl'></i> Jadwal Pelajaran Hari Ini
            </h3>
            
            <div class="relative border-l-2 border-gray-100 ml-3 space-y-6">
                <!-- Timeline Item -->
                <div class="relative pl-6">
                    <div class="absolute -left-1.5 top-1.5 w-3 h-3 bg-gray-300 rounded-full border-2 border-white"></div>
                    <p class="text-xs text-gray-400 mb-0.5">07:30 - 09:00</p>
                    <h4 class="font-bold text-gray-800">Pendidikan Agama Islam</h4>
                    <p class="text-sm text-gray-500">Bpk. H. Ahmad, S.Ag</p>
                </div>
                <!-- Timeline Item Aktif -->
                <div class="relative pl-6">
                    <div class="absolute -left-2 top-1.5 w-4 h-4 bg-amber-400 rounded-full border-4 border-white shadow-sm ring-2 ring-amber-100"></div>
                    <p class="text-xs text-amber-600 font-semibold mb-0.5">09:15 - 11:30 (Sedang Berjalan)</p>
                    <h4 class="font-bold text-[#1E3A8A]">Pemrograman Web & Perangkat Bergerak</h4>
                    <p class="text-sm text-gray-500">Bpk. Budi Guru, S.Kom</p>
                </div>
                <!-- Timeline Item -->
                <div class="relative pl-6">
                    <div class="absolute -left-1.5 top-1.5 w-3 h-3 bg-gray-300 rounded-full border-2 border-white"></div>
                    <p class="text-xs text-gray-400 mb-0.5">13:00 - 14:30</p>
                    <h4 class="font-bold text-gray-800">Bahasa Indonesia</h4>
                    <p class="text-sm text-gray-500">Ibu Sri Wahyuni, S.Pd</p>
                </div>
            </div>
        </div>

        <!-- Pengumuman Kelas -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i class='bx bxs-megaphone text-blue-500 text-xl'></i> Papan Pengumuman
            </h3>
            
            <div class="space-y-4">
                <div class="p-4 bg-blue-50 rounded-xl border border-blue-100">
                    <div class="flex justify-between items-start mb-2">
                        <h4 class="font-bold text-[#1E3A8A]">Pengumpulan Tugas Akhir Web</h4>
                        <span class="text-[10px] bg-red-100 text-red-600 px-2 py-0.5 rounded-full font-bold uppercase">Penting</span>
                    </div>
                    <p class="text-sm text-gray-600">Batas akhir pengumpulan project web sekolah berbasis Laravel adalah hari Jumat, pukul 23:59 via Google Classroom.</p>
                    <p class="text-xs text-gray-400 mt-2">Oleh: Budi Guru, S.Kom - 2 Jam yang lalu</p>
                </div>
                
                <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
                    <div class="flex justify-between items-start mb-2">
                        <h4 class="font-bold text-gray-800">Jadwal Pengambilan Foto Ijazah</h4>
                    </div>
                    <p class="text-sm text-gray-600">Seluruh siswa kelas XII diwajibkan menggunakan seragam putih abu-abu lengkap dengan dasi pada hari Senin depan.</p>
                    <p class="text-xs text-gray-400 mt-2">Oleh: Admin TU - Kemarin</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>