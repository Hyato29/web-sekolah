<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Informasi Sekolah (SIS)</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts (Tailwind & Alpine) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- ScrollReveal JS -->
    <script src="https://unpkg.com/scrollreveal"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        /* Kustomisasi warna sesuai PRD */
        .bg-primary {
            background-color: #1E3A8A;
        }

        .text-primary {
            color: #1E3A8A;
        }

        .bg-accent {
            background-color: #F59E0B;
        }

        .hover-bg-accent:hover {
            background-color: #d97706;
        }
    </style>
</head>

<body class="antialiased text-gray-800 bg-gray-50">

    <!-- Navbar -->
    <nav x-data="{ open: false }" class="fixed w-full z-50 bg-white shadow-md transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="#" class="flex items-center gap-2">
                        <div
                            class="w-10 h-10 bg-primary rounded-full flex items-center justify-center text-white font-bold text-xl">
                            S</div>
                        <span class="font-bold text-2xl text-primary tracking-tight">Sekolah<span
                                class="text-amber-500">Hebat</span></span>
                    </a>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#beranda" class="text-gray-600 hover:text-primary font-medium transition">Beranda</a>
                    <a href="#profil" class="text-gray-600 hover:text-primary font-medium transition">Profil</a>
                    <a href="#fasilitas" class="text-gray-600 hover:text-primary font-medium transition">Fasilitas</a>
                    <a href="#pengumuman" class="text-gray-600 hover:text-primary font-medium transition">Pengumuman</a>
                    <a href="#galeri" class="text-gray-600 hover:text-primary font-medium transition">Galeri</a>
                    <a href="#kontak" class="text-gray-600 hover:text-primary font-medium transition">Kontak</a>

                    <div class="flex items-center space-x-4 border-l pl-4 border-gray-200">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-primary font-semibold hover:underline">Ke
                                Dashboard</a>
                        @else
                            <a href="{{ route('login') }}"
                                class="text-gray-600 hover:text-primary font-medium transition">Login</a>
                            <a href="#ppdb"
                                class="bg-accent hover-bg-accent text-white px-5 py-2.5 rounded-lg font-semibold transition shadow-lg shadow-amber-500/30">Daftar
                                PPDB</a>
                        @endauth
                    </div>
                </div>

                <!-- Mobile Menu Button -->
                <div class="flex items-center md:hidden">
                    <button @click="open = !open" class="text-gray-500 hover:text-primary focus:outline-none">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="open" class="md:hidden bg-white border-t border-gray-100 shadow-xl" x-transition>
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                <a @click="open = false" href="#beranda"
                    class="block px-3 py-2 text-gray-700 hover:text-primary hover:bg-blue-50 rounded-md">Beranda</a>
                <a @click="open = false" href="#profil"
                    class="block px-3 py-2 text-gray-700 hover:text-primary hover:bg-blue-50 rounded-md">Profil</a>
                <a @click="open = false" href="#fasilitas"
                    class="block px-3 py-2 text-gray-700 hover:text-primary hover:bg-blue-50 rounded-md">Fasilitas</a>
                <a @click="open = false" href="#pengumuman"
                    class="block px-3 py-2 text-gray-700 hover:text-primary hover:bg-blue-50 rounded-md">Pengumuman</a>
                <a @click="open = false" href="#galeri"
                    class="block px-3 py-2 text-gray-700 hover:text-primary hover:bg-blue-50 rounded-md">Galeri</a>
                <a @click="open = false" href="#kontak"
                    class="block px-3 py-2 text-gray-700 hover:text-primary hover:bg-blue-50 rounded-md">Kontak</a>
                @auth
                    <a href="{{ url('/dashboard') }}" class="block px-3 py-2 text-primary font-bold">Dashboard</a>
                @else
                    <a href="{{ route('login') }}"
                        class="block px-3 py-2 text-gray-700 hover:text-primary hover:bg-blue-50 rounded-md">Login
                        Portal</a>
                    <a href="#ppdb"
                        class="block px-3 py-2 mt-2 text-center text-white bg-accent rounded-md font-bold">Daftar PPDB</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Hero Section (Beranda) -->
    <section id="beranda"
        class="pt-32 pb-20 lg:pt-40 lg:pb-28 bg-gradient-to-br from-blue-50 to-white overflow-hidden relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="sr-hero-text z-10">
                    <span
                        class="inline-block py-1 px-3 rounded-full bg-blue-100 text-primary text-sm font-semibold mb-4">Penerimaan
                        Siswa Baru 2026 Dibuka</span>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-gray-900 leading-tight mb-6">
                        Membangun Generasi <br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-blue-400">Cerdas &
                            Berkarakter</span>
                    </h1>
                    <p class="text-lg text-gray-600 mb-8 md:pr-10 leading-relaxed">
                        Selamat datang di portal resmi Sekolah Hebat. Kami berkomitmen memberikan pendidikan berkualitas
                        dengan fasilitas modern dan kurikulum berstandar nasional.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="#ppdb"
                            class="bg-primary hover:bg-blue-800 text-white px-8 py-3.5 rounded-lg font-semibold transition text-center shadow-lg shadow-blue-900/30">Info
                            PPDB Online</a>
                        <a href="#profil"
                            class="bg-white border-2 border-gray-200 hover:border-primary hover:text-primary text-gray-700 px-8 py-3.5 rounded-lg font-semibold transition text-center">Jelajahi
                            Profil</a>
                    </div>
                </div>
                <div class="sr-hero-img relative">
                    <!-- Placeholder Image (Bisa diganti image riil) -->
                    <div class="relative rounded-2xl overflow-hidden shadow-2xl aspect-[4/3] bg-gray-200">
                        <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                            alt="Siswa belajar" class="object-cover w-full h-full" />
                        <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
                    </div>
                    <!-- Floating Badge -->
                    <div class="absolute -bottom-6 -left-6 bg-white p-4 rounded-xl shadow-xl flex items-center gap-4 animate-bounce"
                        style="animation-duration: 3s;">
                        <div class="w-12 h-12 bg-accent rounded-full flex items-center justify-center text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 14l9-5-9-5-9 5 9 5z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 font-medium">Akreditasi</p>
                            <p class="text-xl font-bold text-gray-900">A (Unggul)</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Profil Section -->
    <section id="profil" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16 sr-heading">
                <h2 class="text-primary font-bold tracking-wide uppercase text-sm mb-2">Tentang Kami</h2>
                <h3 class="text-3xl md:text-4xl font-bold text-gray-900">Profil Sekolah Hebat</h3>
                <div class="w-20 h-1.5 bg-accent mx-auto mt-6 rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                <div class="sr-card bg-gray-50 rounded-2xl p-8 border border-gray-100 shadow-sm">
                    <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                            </path>
                        </svg>
                    </div>
                    <h4 class="text-2xl font-bold text-gray-900 mb-4">Visi</h4>
                    <p class="text-gray-600 leading-relaxed">Menjadi institusi pendidikan terdepan yang menghasilkan
                        lulusan beriman, bertakwa, berwawasan global, dan menguasai teknologi di era digital.</p>
                </div>
                <div class="sr-card bg-gray-50 rounded-2xl p-8 border border-gray-100 shadow-sm"
                    style="transition-delay: 200ms;">
                    <div class="w-14 h-14 bg-amber-100 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                            </path>
                        </svg>
                    </div>
                    <h4 class="text-2xl font-bold text-gray-900 mb-4">Misi</h4>
                    <ul class="text-gray-600 space-y-3 leading-relaxed">
                        <li class="flex items-start"><svg class="w-5 h-5 text-green-500 mr-2 mt-0.5 shrink-0"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd"></path>
                            </svg> Menyelenggarakan pembelajaran interaktif dan inovatif.</li>
                        <li class="flex items-start"><svg class="w-5 h-5 text-green-500 mr-2 mt-0.5 shrink-0"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd"></path>
                            </svg> Membina karakter budi pekerti melalui kegiatan keagamaan.</li>
                        <li class="flex items-start"><svg class="w-5 h-5 text-green-500 mr-2 mt-0.5 shrink-0"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd"></path>
                            </svg> Meningkatkan kualitas pendidik secara berkelanjutan.</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Fasilitas Section -->
    <section id="fasilitas" class="py-20 bg-gray-50 border-y border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16 sr-heading">
                <h2 class="text-primary font-bold tracking-wide uppercase text-sm mb-2">Penunjang Belajar</h2>
                <h3 class="text-3xl md:text-4xl font-bold text-gray-900">Fasilitas Unggulan</h3>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <!-- Fasilitas Items -->
                @php
                    $fasilitas = [
                        [
                            'icon' =>
                                'M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',
                            'title' => 'Lab Komputer',
                        ],
                        [
                            'icon' =>
                                'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253',
                            'title' => 'Perpustakaan',
                        ],
                        [
                            'icon' =>
                                'M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z',
                            'title' => 'Lab Sains',
                        ],
                        [
                            'icon' =>
                                'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6',
                            'title' => 'Asrama Siswa',
                        ],
                    ];
                @endphp

                @foreach ($fasilitas as $index => $item)
                    <div
                        class="sr-fasilitas bg-white p-6 rounded-2xl text-center shadow-sm border border-gray-100 hover:shadow-lg transition-shadow group">
                        <div
                            class="w-16 h-16 mx-auto bg-blue-50 group-hover:bg-primary transition-colors rounded-full flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-primary group-hover:text-white transition-colors" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="{{ $item['icon'] }}"></path>
                            </svg>
                        </div>
                        <h4 class="font-bold text-gray-800">{{ $item['title'] }}</h4>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Pengumuman & Berita -->
    <section id="berita" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16 sr-bottom">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Berita & Informasi Terbaru</h2>
                <div class="w-24 h-1 bg-[#1E3A8A] mx-auto rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @forelse($pengumuman as $p)
                    <div
                        class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100 hover:shadow-xl transition duration-300 sr-bottom">
                        <!-- Jika ada gambar tampilkan, jika tidak pakai gambar placeholder -->
                        <img src="{{ $p->gambar ? Storage::url($p->gambar) : 'https://images.unsplash.com/photo-1546410531-bb4caa6b424d?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80' }}"
                            alt="Berita" class="w-full h-48 object-cover">
                        <div class="p-6">
                            <span
                                class="text-xs font-bold bg-amber-100 text-amber-700 px-3 py-1 rounded-full">{{ $p->kategori }}</span>
                            <h3 class="font-bold text-xl text-gray-900 mt-4 mb-2">{{ $p->judul }}</h3>
                            <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ $p->isi }}</p>
                            <div class="text-xs text-gray-400 font-medium"><i class='bx bx-calendar'></i>
                                {{ $p->tanggal_publish->translatedFormat('d M Y') }}</div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center text-gray-500 py-10">
                        Belum ada informasi publik yang diterbitkan.
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Galeri Section -->
    <section id="galeri" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16 sr-bottom">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Galeri Kegiatan</h2>
                <div class="w-24 h-1 bg-[#1E3A8A] mx-auto rounded-full"></div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 lg:gap-6 sr-bottom">
                @forelse($galeri as $g)
                    <div class="relative group overflow-hidden rounded-2xl aspect-[4/3] bg-gray-100">
                        <img src="{{ Storage::url($g->foto) }}" alt="{{ $g->judul }}"
                            class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex flex-col justify-end p-6">
                            <h3 class="text-white font-bold text-lg">{{ $g->judul }}</h3>
                            <p class="text-gray-300 text-sm">{{ $g->keterangan }}</p>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center text-gray-500 py-10">
                        Foto kegiatan sekolah belum diunggah ke galeri.
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- PPDB CTA Section -->
    <section id="ppdb" class="py-20 bg-primary relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10"
            style="background-image: radial-gradient(#fff 1px, transparent 1px); background-size: 20px 20px;"></div>

        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10 sr-cta">
            <h2 class="text-3xl md:text-5xl font-bold text-white mb-6">Penerimaan Peserta Didik Baru (PPDB) 2026/2027
            </h2>
            <p class="text-blue-200 text-lg mb-10 leading-relaxed max-w-3xl mx-auto">
                Bergabunglah bersama kami dan raih prestasi terbaikmu. Pendaftaran kini dapat dilakukan secara online
                melalui portal Sistem Informasi Sekolah.
            </p>

            <div class="flex flex-col sm:flex-row justify-center items-center gap-4">
                <!-- Tombol Utama: Daftar -->
                <a href="{{ route('ppdb.create') }}"
                    class="w-full sm:w-auto bg-accent hover-bg-accent text-white px-8 py-4 rounded-xl font-bold text-lg transition shadow-2xl">
                    Daftar Sekarang
                </a>

                <!-- Tombol Kedua: Cek Status -->
                <a href="{{ route('ppdb.cek_status') }}"
                    class="w-full sm:w-auto bg-blue-800 hover:bg-blue-700 text-white px-8 py-4 rounded-xl font-bold text-lg transition border border-blue-600 flex items-center justify-center gap-2">
                    <i class='bx bx-search-alt-2 text-xl'></i> Cek Status
                </a>

                <!-- Tombol Ketiga: Brosur -->
                <a href="#"
                    class="w-full sm:w-auto bg-transparent hover:bg-white/10 border border-blue-400 text-blue-100 px-8 py-4 rounded-xl font-bold text-lg transition flex items-center justify-center gap-2">
                    <i class='bx bx-download text-xl'></i> Brosur (PDF)
                </a>
            </div>
        </div>
    </section>

    <!-- Footer & Kontak -->
    <footer id="kontak" class="bg-white border-t border-gray-200 pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                <div class="col-span-1 md:col-span-1 sr-footer">
                    <a href="#" class="flex items-center gap-2 mb-6">
                        <div
                            class="w-8 h-8 bg-primary rounded-full flex items-center justify-center text-white font-bold">
                            S</div>
                        <span class="font-bold text-xl text-primary tracking-tight">Sekolah<span
                                class="text-amber-500">Hebat</span></span>
                    </a>
                    <p class="text-gray-500 text-sm leading-relaxed mb-6">Sistem Informasi Sekolah terpadu untuk
                        mendukung transparansi dan efisiensi pendidikan digital.</p>
                </div>

                <div class="sr-footer">
                    <h4 class="font-bold text-gray-900 mb-6">Tautan Cepat</h4>
                    <ul class="space-y-3 text-sm text-gray-500">
                        <li><a href="#profil" class="hover:text-primary transition">Profil Sekolah</a></li>
                        <li><a href="#pengumuman" class="hover:text-primary transition">Berita & Pengumuman</a></li>
                        <li><a href="#galeri" class="hover:text-primary transition">Galeri Kegiatan</a></li>
                        <li><a href="#ppdb" class="hover:text-primary transition">Informasi PPDB</a></li>
                    </ul>
                </div>

                <div class="col-span-1 md:col-span-2 sr-footer">
                    <h4 class="font-bold text-gray-900 mb-6">Kontak & Lokasi</h4>
                    <div class="flex items-start text-sm text-gray-500 mb-4">
                        <svg class="w-5 h-5 text-primary mr-3 shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <p>Jl. Pendidikan No. 123, Kota Cerdas, Provinsi Hebat 12345, Indonesia</p>
                    </div>
                    <div class="flex items-center text-sm text-gray-500 mb-4">
                        <svg class="w-5 h-5 text-primary mr-3 shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                            </path>
                        </svg>
                        <p>(021) 555-0198</p>
                    </div>
                    <div class="flex items-center text-sm text-gray-500">
                        <svg class="w-5 h-5 text-primary mr-3 shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                        <p>info@sekolahhebat.sch.id</p>
                    </div>
                </div>
            </div>
            <div
                class="border-t border-gray-100 pt-8 flex flex-col md:flex-row justify-between items-center text-sm text-gray-400">
                <p>&copy; {{ date('Y') }} Sistem Informasi Sekolah. All rights reserved.</p>
                <div class="flex space-x-4 mt-4 md:mt-0">
                    <a href="#" class="hover:text-primary transition">Facebook</a>
                    <a href="#" class="hover:text-primary transition">Instagram</a>
                    <a href="#" class="hover:text-primary transition">YouTube</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Inisialisasi ScrollReveal JS -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Konfigurasi default
            const sr = ScrollReveal({
                distance: '40px',
                duration: 1000,
                delay: 200,
                reset: false // Set true jika ingin animasi berulang saat di-scroll naik-turun
            });

            // Hero Section
            sr.reveal('.sr-hero-text', {
                origin: 'left'
            });
            sr.reveal('.sr-hero-img', {
                origin: 'right',
                delay: 400
            });

            // Headings (Judul Section)
            sr.reveal('.sr-heading', {
                origin: 'bottom',
                distance: '20px'
            });

            // Cards (Visi Misi, Berita)
            sr.reveal('.sr-card', {
                origin: 'bottom',
                interval: 200
            });

            // Fasilitas Grid
            sr.reveal('.sr-fasilitas', {
                origin: 'bottom',
                interval: 100,
                scale: 0.9
            });

            // Galeri
            sr.reveal('.sr-gallery', {
                origin: 'bottom',
                interval: 150
            });

            // CTA PPDB
            sr.reveal('.sr-cta', {
                origin: 'bottom',
                scale: 0.9
            });

            // Footer
            sr.reveal('.sr-footer', {
                origin: 'bottom',
                interval: 100,
                distance: '20px'
            });
        });
    </script>

</body>

</html>
