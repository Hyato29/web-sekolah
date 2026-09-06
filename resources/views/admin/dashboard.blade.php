<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Admin Tata Usaha') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold text-blue-900 mb-2">Selamat Datang, {{ Auth::user()->name }}</h3>
                    <p class="text-sm text-gray-600">Anda login sebagai <span class="font-semibold text-blue-600">Admin</span>. Dari sini Anda dapat mengelola data master, akun pengguna, dan konfigurasi sekolah.</p>
                </div>
            </div>
            
            <!-- Grid Layout untuk Card Navigasi Cepat -->
            <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Card 1 -->
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 flex items-center space-x-4">
                    <div class="p-3 bg-blue-100 text-blue-600 rounded-full">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Total Pengguna</p>
                        <p class="text-xl font-bold text-gray-800">3 Aktif</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>