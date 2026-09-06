<x-app-layout>
    <x-slot name="header">
        Dashboard Guru
    </x-slot>

    <!-- Sambutan -->
    <div class="bg-[#1E3A8A] rounded-2xl p-8 shadow-lg text-white mb-8 relative overflow-hidden">
        <div class="relative z-10">
            <h2 class="text-2xl md:text-3xl font-bold mb-2">Selamat Datang, Bapak/Ibu {{ Auth::user()->name }}!</h2>
            <p class="text-blue-100 mb-6 max-w-2xl">Semoga hari ini menyenangkan. Anda memiliki 3 jadwal kelas yang harus diampu hari ini. Jangan lupa untuk mengisi nilai kehadiran dan tugas siswa.</p>
            <a href="#" class="inline-block bg-amber-400 hover:bg-amber-500 text-gray-900 font-bold px-6 py-2.5 rounded-lg transition-colors">
                Input Nilai Kelas
            </a>
        </div>
        <i class='bx bxs-graduation absolute -bottom-10 -right-10 text-9xl text-white/10'></i>
    </div>

    <!-- Grid Data Guru -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Kolom Jadwal (Kiri, lebih lebar) -->
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i class='bx bx-calendar text-[#1E3A8A] text-xl'></i> Jadwal Mengajar Hari Ini
            </h3>
            
            <div class="space-y-4">
                <!-- Item Jadwal -->
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border border-gray-100">
                    <div class="flex items-center gap-4">
                        <div class="bg-blue-100 text-[#1E3A8A] px-4 py-2 rounded-lg font-bold text-center">
                            <span class="block text-xs font-normal">Jam 1-2</span>
                            07:30
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900">Matematika Wajib</h4>
                            <p class="text-sm text-gray-500">Kelas XII MIPA 1</p>
                        </div>
                    </div>
                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Selesai</span>
                </div>
                
                <!-- Item Jadwal -->
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border-l-4 border-l-amber-400 shadow-sm">
                    <div class="flex items-center gap-4">
                        <div class="bg-amber-100 text-amber-700 px-4 py-2 rounded-lg font-bold text-center">
                            <span class="block text-xs font-normal">Jam 3-4</span>
                            10:15
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900">Matematika Wajib</h4>
                            <p class="text-sm text-gray-500">Kelas XII MIPA 2</p>
                        </div>
                    </div>
                    <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-semibold">Sedang Berjalan</span>
                </div>
            </div>
        </div>

        <!-- Kolom Widget (Kanan) -->
        <div class="space-y-6">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <div class="flex items-center gap-4 mb-2">
                    <div class="w-12 h-12 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center text-2xl"><i class='bx bx-book-reader'></i></div>
                    <div>
                        <h4 class="text-3xl font-bold text-gray-900">4</h4>
                        <p class="text-sm text-gray-500">Total Kelas Diampu</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <div class="flex items-center gap-4 mb-2">
                    <div class="w-12 h-12 rounded-full bg-green-100 text-green-600 flex items-center justify-center text-2xl"><i class='bx bx-user-check'></i></div>
                    <div>
                        <h4 class="text-3xl font-bold text-gray-900">142</h4>
                        <p class="text-sm text-gray-500">Total Siswa Diajar</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>