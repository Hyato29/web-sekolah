<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cek Status PPDB - Sekolah Hebat</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body class="bg-gray-50 font-sans text-gray-900 antialiased">

    <div
        class="min-h-screen flex flex-col items-center justify-center py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 bg-[#1E3A8A] h-64 z-0"></div>

        <div class="max-w-xl w-full space-y-8 bg-white p-10 rounded-3xl shadow-xl z-10 border border-gray-100">

            <div class="text-center">
                <div
                    class="w-16 h-16 bg-[#1E3A8A] text-white rounded-2xl flex items-center justify-center mx-auto mb-4 text-3xl font-bold shadow-lg">
                    S</div>
                <h2 class="text-3xl font-extrabold text-gray-900">Cek Status Seleksi</h2>
                <p class="mt-2 text-sm text-gray-500">Masukkan nomor pendaftaran PPDB Anda (Cth: PPDB-2026-0001)</p>
            </div>

            <!-- Form Pencarian -->
            <form action="{{ route('ppdb.cek_status') }}" method="GET" class="flex gap-3">
                <input type="text" name="nomor_pendaftaran" value="{{ request('nomor_pendaftaran') }}" required
                    class="w-full border-gray-300 rounded-xl shadow-sm py-3 px-4 focus:ring-[#1E3A8A] focus:border-[#1E3A8A] text-center font-mono font-bold text-lg"
                    placeholder="Nomor Pendaftaran">
                <button type="submit"
                    class="bg-amber-400 hover:bg-amber-500 text-gray-900 font-bold py-3 px-6 rounded-xl shadow-md transition">
                    <i class='bx bx-search text-xl'></i>
                </button>
            </form>

            <!-- Hasil Pencarian -->
            @if ($dicari)
                <div class="pt-6 border-t border-gray-100 mt-6">
                    @if ($pendaftar)
                        <div class="bg-blue-50 border border-blue-100 rounded-2xl p-6 text-center">
                            <h3 class="text-sm font-bold text-[#1E3A8A] uppercase tracking-wider mb-1">Hasil Pencarian
                            </h3>
                            <p class="text-2xl font-bold text-gray-900 mb-4">{{ $pendaftar->nama_lengkap }}</p>

                            <div class="bg-white rounded-xl p-4 inline-block shadow-sm mb-2 border border-gray-100">
                                <p class="text-xs text-gray-500 mb-1">Status Saat Ini:</p>

                                @php
                                    $badgeClass = match ($pendaftar->status) {
                                        'Diterima' => 'bg-green-100 text-green-700 border-green-200',
                                        'Ditolak' => 'bg-red-100 text-red-700 border-red-200',
                                        'Revisi' => 'bg-blue-100 text-blue-700 border-blue-200',
                                        default => 'bg-amber-100 text-amber-700 border-amber-200',
                                    };
                                    $iconClass = match ($pendaftar->status) {
                                        'Diterima' => 'bx-check-circle',
                                        'Ditolak' => 'bx-x-circle',
                                        'Revisi' => 'bx-edit',
                                        default => 'bx-time-five',
                                    };
                                @endphp

                                <div
                                    class="px-4 py-2 rounded-lg border flex items-center justify-center gap-2 {{ $badgeClass }}">
                                    <i class='bx {{ $iconClass }} text-xl'></i>
                                    <span class="font-bold text-lg">{{ $pendaftar->status }}</span>
                                </div>
                            </div>

                            <div class="text-sm text-gray-600 mt-4">
                                @if ($pendaftar->status == 'Menunggu')
                                    <p>Berkas Anda sedang dalam proses verifikasi oleh panitia.</p>
                                @elseif($pendaftar->status == 'Diterima')
                                    <p class="mb-4">Selamat! Anda dinyatakan lolos seleksi. Silakan tunggu informasi
                                        daftar ulang selanjutnya.</p>

                                    <!-- CTA Grup WhatsApp -->
                                    <div
                                        class="bg-green-50 border border-green-200 rounded-xl p-4 flex flex-col items-center justify-center gap-3">
                                        <p class="font-semibold text-green-800 text-sm">Silakan bergabung ke Grup
                                            WhatsApp Calon Siswa Baru untuk mendapatkan panduan daftar ulang.</p>
                                        <a href="https://chat.whatsapp.com/GantiDenganLinkGrupAsliSekolah"
                                            target="_blank" rel="noopener noreferrer"
                                            class="inline-flex items-center gap-2 bg-[#25D366] hover:bg-[#128C7E] text-white font-bold py-2.5 px-6 rounded-lg shadow-md transition transform hover:-translate-y-0.5">
                                            <i class='bx bxl-whatsapp text-2xl'></i> Gabung Grup WA
                                        </a>
                                    </div>
                                @elseif($pendaftar->status == 'Revisi')
                                    <p>Ada berkas yang tidak sesuai. Silakan hubungi panitia PPDB ke sekolah.</p>
                                @else
                                    <p>Mohon maaf, Anda belum lolos seleksi pada periode ini. Jangan patah semangat!</p>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="bg-red-50 border border-red-100 rounded-2xl p-6 text-center">
                            <i class='bx bx-error-circle text-4xl text-red-400 mb-2'></i>
                            <h3 class="text-lg font-bold text-red-700 mb-1">Data Tidak Ditemukan</h3>
                            <p class="text-sm text-red-600">Pastikan nomor pendaftaran yang Anda masukkan sudah benar
                                beserta formatnya (contoh: PPDB-2026-0001).</p>
                        </div>
                    @endif
                </div>
            @endif

            <div class="text-center mt-6">
                <a href="{{ url('/') }}"
                    class="text-sm font-medium text-gray-500 hover:text-[#1E3A8A] flex items-center justify-center gap-1">
                    <i class='bx bx-arrow-back'></i> Kembali ke Beranda
                </a>
            </div>

        </div>
    </div>
</body>

</html>
