<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pendaftaran PPDB Online - Sekolah Hebat</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body class="bg-gray-50 font-sans text-gray-900 antialiased">

    <div
        class="min-h-screen flex flex-col items-center justify-center py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 bg-[#1E3A8A] h-64 z-0"></div>

        <div class="max-w-2xl w-full space-y-8 bg-white p-10 rounded-3xl shadow-xl z-10 border border-gray-100">

            <div class="text-center">
                <div
                    class="w-16 h-16 bg-[#1E3A8A] text-white rounded-2xl flex items-center justify-center mx-auto mb-4 text-3xl font-bold shadow-lg">
                    S</div>
                <h2 class="text-3xl font-extrabold text-gray-900">Formulir PPDB Online</h2>
                <p class="mt-2 text-sm text-gray-500">Tahun Ajaran 2026/2027</p>
            </div>

            @if (session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg">
                    <div class="flex">
                        <div class="flex-shrink-0"><i class='bx bx-check-circle text-green-500 text-xl'></i></div>
                        <div class="ml-3">
                            <h3 class="text-sm font-bold text-green-800">Pendaftaran Berhasil!</h3>
                            <p class="text-sm text-green-700 mt-1">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <form class="mt-8 space-y-6" action="{{ route('ppdb.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="col-span-1 md:col-span-2">
                        <label class="block text-sm font-bold text-gray-700 mb-1">Nama Lengkap Calon Siswa</label>
                        <input type="text" name="nama_lengkap" required
                            class="w-full border-gray-300 rounded-lg shadow-sm py-2.5 px-3 focus:ring-[#1E3A8A] focus:border-[#1E3A8A]"
                            placeholder="Sesuai Akta Kelahiran">
                        @error('nama_lengkap')
                            <span class="text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Asal Sekolah (SMP/MTs)</label>
                        <input type="text" name="asal_sekolah" required
                            class="w-full border-gray-300 rounded-lg shadow-sm py-2.5 px-3 focus:ring-[#1E3A8A]">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Nomor Telepon/WhatsApp</label>
                        <input type="text" name="nomor_telepon" required
                            class="w-full border-gray-300 rounded-lg shadow-sm py-2.5 px-3 focus:ring-[#1E3A8A]">
                    </div>

                    <div class="col-span-1 md:col-span-2">
                        <label class="block text-sm font-bold text-gray-700 mb-1">Nama Orang Tua / Wali</label>
                        <input type="text" name="nama_orang_tua" required
                            class="w-full border-gray-300 rounded-lg shadow-sm py-2.5 px-3 focus:ring-[#1E3A8A]">
                    </div>

                    <div class="col-span-1 md:col-span-2">
                        <label class="block text-sm font-bold text-gray-700 mb-1">Alamat Lengkap</label>
                        <textarea name="alamat_lengkap" rows="3" required
                            class="w-full border-gray-300 rounded-lg shadow-sm py-2.5 px-3 focus:ring-[#1E3A8A]"></textarea>
                    </div>

                    <div class="col-span-1 md:col-span-2 p-5 bg-blue-50 border border-blue-100 rounded-xl">
                        <label class="block text-sm font-bold text-[#1E3A8A] mb-2">Unggah Berkas (Kartu Keluarga /
                            Ijazah)</label>
                        <p class="text-xs text-gray-500 mb-3">Format yang didukung: PDF, JPG, PNG. Maksimal ukuran 2MB.
                        </p>
                        <input type="file" name="berkas_dokumen" required accept=".pdf,.jpg,.jpeg,.png"
                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-[#1E3A8A] file:text-white hover:file:bg-blue-800 transition">
                        @error('berkas_dokumen')
                            <span class="text-xs text-red-500 block mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                    <a href="{{ url('/') }}" class="text-sm font-medium text-gray-500 hover:text-[#1E3A8A]">Kembali
                        ke Beranda</a>
                    <button type="submit"
                        class="bg-amber-400 hover:bg-amber-500 text-gray-900 font-bold py-3 px-8 rounded-xl shadow-lg transition transform hover:-translate-y-0.5">
                        Kirim Pendaftaran
                    </button>
                </div>
                <div class="text-center mt-6">
                    <p class="text-sm text-gray-500">Sudah mendaftar? <a href="{{ route('ppdb.cek_status') }}"
                            class="text-[#1E3A8A] font-bold hover:underline">Cek Status Disini</a></p>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
