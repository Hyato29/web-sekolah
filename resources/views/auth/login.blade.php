<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Portal - Sistem Informasi Sekolah</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Inter', sans-serif; }
        .bg-primary { background-color: #1E3A8A; }
        .text-primary { color: #1E3A8A; }
        .border-primary { border-color: #1E3A8A; }
        .ring-primary { --tw-ring-color: #1E3A8A; }
        .bg-accent { background-color: #F59E0B; }
    </style>
</head>
<body class="antialiased bg-white text-gray-900">

    <div class="flex min-h-screen">
        
        <!-- Sisi Kiri: Branding & Gambar (Sembunyi di Mobile) -->
        <div class="hidden lg:flex lg:w-1/2 bg-primary relative overflow-hidden items-center justify-center">
            <!-- Background Image dengan Overlay -->
            <div class="absolute inset-0 bg-primary/90 z-10"></div>
            <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" alt="School Background" class="absolute inset-0 w-full h-full object-cover" />
            
            <!-- Konten Branding -->
            <div class="relative z-20 text-center px-12 text-white">
                <div class="w-20 h-20 bg-white/10 backdrop-blur-md rounded-2xl flex items-center justify-center mx-auto mb-8 border border-white/20 shadow-xl">
                    <span class="text-4xl font-extrabold text-white">S</span>
                </div>
                <h1 class="text-4xl font-bold mb-4 tracking-tight">Sekolah<span class="text-amber-400">Hebat</span></h1>
                <p class="text-blue-100 text-lg leading-relaxed max-w-md mx-auto">
                    Sistem Informasi Sekolah terpadu. Masuk untuk mengakses jadwal, nilai akademik, dan pengumuman terbaru.
                </p>
                
                <!-- Dekorasi Pattern -->
                <div class="absolute top-10 left-10 w-24 h-24 bg-white/5 rounded-full blur-2xl"></div>
                <div class="absolute bottom-10 right-10 w-32 h-32 bg-amber-400/10 rounded-full blur-2xl"></div>
            </div>
        </div>

        <!-- Sisi Kanan: Form Login -->
        <div class="flex w-full lg:w-1/2 items-center justify-center p-8 sm:p-12 xl:p-24 bg-white">
            <div class="w-full max-w-md">
                
                <!-- Logo untuk Mobile (Muncul hanya di layar kecil) -->
                <div class="lg:hidden text-center mb-8">
                    <div class="w-16 h-16 bg-primary rounded-full flex items-center justify-center mx-auto mb-4 text-white font-bold text-2xl shadow-lg">S</div>
                    <h2 class="text-2xl font-bold text-primary">Sekolah<span class="text-amber-500">Hebat</span></h2>
                </div>

                <div class="mb-10">
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">Selamat Datang 👋</h2>
                    <p class="text-gray-500">Silakan masukkan kredensial Anda untuk masuk ke sistem.</p>
                </div>

                <!-- Session Status / Pesan Sukses -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <!-- Form Login -->
                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Email / Username / NISN -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email / NISN / NIP</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path></svg>
                            </div>
                            <!-- Catatan: Name tetap 'email' agar kompatibel dengan validasi bawaan Laravel Breeze -->
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl focus:ring-primary focus:border-primary sm:text-sm transition shadow-sm placeholder-gray-400" placeholder="contoh: siswa@sekolah.com">
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500 text-sm" />
                    </div>

                    <!-- Password -->
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label for="password" class="block text-sm font-medium text-gray-700">Kata Sandi</label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-sm font-medium text-primary hover:underline transition">Lupa sandi?</a>
                            @endif
                        </div>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                            <input id="password" type="password" name="password" required autocomplete="current-password" class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl focus:ring-primary focus:border-primary sm:text-sm transition shadow-sm placeholder-gray-400" placeholder="••••••••">
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500 text-sm" />
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center">
                        <input id="remember_me" type="checkbox" name="remember" class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded transition">
                        <label for="remember_me" class="ml-2 block text-sm text-gray-600">
                            Ingat saya
                        </label>
                    </div>

                    <!-- Tombol Login -->
                    <div>
                        <button type="submit" class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-lg shadow-blue-900/20 text-sm font-bold text-white bg-primary hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-all duration-300">
                            Masuk ke Portal
                        </button>
                    </div>
                </form>

                <!-- Tombol Kembali -->
                <div class="mt-8 text-center text-sm text-gray-500">
                    <a href="{{ route('home') }}" class="inline-flex items-center hover:text-primary transition font-medium">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Kembali ke Halaman Utama
                    </a>
                </div>
                
            </div>
        </div>

    </div>

</body>
</html>