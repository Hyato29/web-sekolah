<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Sistem Informasi Sekolah') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    
    <!-- Boxicons Library -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900">

    <!-- Alpine.js Container untuk state sidebar -->
    <div x-data="{ sidebarOpen: window.innerWidth >= 1024 }" @resize.window="sidebarOpen = window.innerWidth >= 1024" class="flex h-screen overflow-hidden">

        <!-- Mobile Overlay -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 z-20 bg-black/50 lg:hidden" x-transition.opacity></div>

        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0 w-64' : '-translate-x-full w-64 lg:w-0 lg:translate-x-0'" class="fixed inset-y-0 left-0 z-30 flex flex-col bg-[#1E3A8A] text-white transition-all duration-300 ease-in-out shadow-xl lg:static overflow-hidden shrink-0">
            
            <!-- Logo Area -->
            <div class="flex items-center justify-center h-20 border-b border-blue-800 shrink-0 px-4">
                <div class="w-8 h-8 bg-white text-[#1E3A8A] rounded-lg flex items-center justify-center font-bold text-xl mr-2">S</div>
                <span class="text-xl font-bold tracking-tight whitespace-nowrap">Sekolah<span class="text-amber-400">Hebat</span></span>
            </div>

            <!-- Menu Links -->
            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                <div class="text-xs font-semibold text-blue-300 uppercase tracking-wider mb-4 ml-2">Menu Utama</div>

                @if(auth()->user()->hasRole('admin'))
                    <!-- Menu Admin -->
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-blue-800 transition {{ request()->routeIs('admin.dashboard') ? 'bg-blue-800 border-l-4 border-amber-400' : 'border-l-4 border-transparent' }}">
                        <i class='bx bxs-dashboard text-xl'></i>
                        <span class="whitespace-nowrap">Dashboard</span>
                    </a>
                    <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-blue-800 transition border-l-4 border-transparent">
                        <i class='bx bx-data text-xl'></i>
                        <span class="whitespace-nowrap">Data Master</span>
                    </a>
                    <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-blue-800 transition border-l-4 border-transparent">
                        <i class='bx bxs-user-detail text-xl'></i>
                        <span class="whitespace-nowrap">Akun Pengguna</span>
                    </a>
                    <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-blue-800 transition border-l-4 border-transparent">
                        <i class='bx bx-file-blank text-xl'></i>
                        <span class="whitespace-nowrap">Verifikasi PPDB</span>
                    </a>

                @elseif(auth()->user()->hasRole('guru'))
                    <!-- Menu Guru -->
                    <a href="{{ route('guru.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-blue-800 transition {{ request()->routeIs('guru.dashboard') ? 'bg-blue-800 border-l-4 border-amber-400' : 'border-l-4 border-transparent' }}">
                        <i class='bx bxs-dashboard text-xl'></i>
                        <span class="whitespace-nowrap">Dashboard</span>
                    </a>
                    <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-blue-800 transition border-l-4 border-transparent">
                        <i class='bx bx-calendar text-xl'></i>
                        <span class="whitespace-nowrap">Jadwal Mengajar</span>
                    </a>
                    <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-blue-800 transition border-l-4 border-transparent">
                        <i class='bx bx-edit text-xl'></i>
                        <span class="whitespace-nowrap">Input Nilai</span>
                    </a>

                @elseif(auth()->user()->hasRole('siswa'))
                    <!-- Menu Siswa -->
                    <a href="{{ route('siswa.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-blue-800 transition {{ request()->routeIs('siswa.dashboard') ? 'bg-blue-800 border-l-4 border-amber-400' : 'border-l-4 border-transparent' }}">
                        <i class='bx bxs-dashboard text-xl'></i>
                        <span class="whitespace-nowrap">Dashboard</span>
                    </a>
                    <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-blue-800 transition border-l-4 border-transparent">
                        <i class='bx bx-calendar-event text-xl'></i>
                        <span class="whitespace-nowrap">Jadwal Pelajaran</span>
                    </a>
                    <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-blue-800 transition border-l-4 border-transparent">
                        <i class='bx bx-award text-xl'></i>
                        <span class="whitespace-nowrap">Nilai Akademik</span>
                    </a>
                @endif
            </nav>

            <!-- Profil & Logout di bawah Sidebar -->
            <div class="border-t border-blue-800 p-4 shrink-0">
                <div class="flex items-center mb-4 px-2">
                    <div class="w-10 h-10 rounded-full bg-amber-400 text-[#1E3A8A] flex items-center justify-center font-bold text-lg mr-3">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div class="overflow-hidden">
                        <p class="text-sm font-bold truncate">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-blue-300 capitalize">{{ Auth::user()->role->name }}</p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col overflow-hidden relative w-full">
            
            <!-- Top Header -->
            <header class="h-20 bg-white border-b border-gray-200 flex items-center justify-between px-6 shrink-0 z-10">
                <div class="flex items-center">
                    <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 hover:text-[#1E3A8A] transition focus:outline-none p-2 rounded-lg hover:bg-gray-100">
                        <i class='bx bx-menu text-3xl'></i>
                    </button>
                    
                    <h2 class="hidden sm:block ml-4 text-xl font-semibold text-gray-800">
                        {{ $header ?? 'Sistem Informasi Sekolah' }}
                    </h2>
                </div>

                <!-- Tombol Logout di Header -->
                <div class="flex items-center gap-4">
                    <div class="hidden md:block text-sm text-gray-500 mr-2">
                        {{ now()->translatedFormat('l, d F Y') }}
                    </div>
                    
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center gap-2 px-4 py-2 bg-red-50 text-red-600 hover:bg-red-600 hover:text-white rounded-lg transition-colors font-medium border border-red-100 hover:border-red-600">
                            <i class='bx bx-log-out text-lg'></i>
                            <span class="hidden sm:inline">Keluar</span>
                        </button>
                    </form>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6 md:p-8">
                {{ $slot }}
            </main>
        </div>

    </div>
</body>
</html>