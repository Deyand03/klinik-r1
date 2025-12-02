<!DOCTYPE html>
<html lang="id" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun Pasien Baru - Klinik Umum Sehat</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Anda mungkin perlu menambahkan konfigurasi Tailwind/DaisyUI custom di sini jika ada animasi atau warna kustom --}}
    {{-- Pastikan kelas seperti 'animate-blob' dan 'brand-secondary' sudah terdefinisi di config Tailwind Anda. --}}

</head>

<body class="font-sans antialiased text-gray-900">

    {{-- Menggunakan x-data="{ showPassword: false, showConfirmPassword: false }" karena ada dua field password --}}
    <div class="min-h-screen flex bg-white" x-data="{ showPassword: false, showConfirmPassword: false }">

        <div class="hidden lg:flex w-1/2 relative bg-brand-secondary overflow-hidden items-center justify-center">
            <div class="absolute inset-0">
                {{-- Gunakan path gambar yang sama --}}
                <img src="https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80"
                    alt="Klinik Hospital" class="w-full h-full object-cover opacity-20 mix-blend-overlay">
            </div>
            {{-- Efek Gradient dan Blob Disalin --}}
            <div
                class="absolute inset-0 bg-linear-to-br from-brand-secondary/90 via-brand-secondary/80 to-brand-primary/40">
            </div>
            <div
                class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-brand-primary rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob">
            </div>
            <div
                class="absolute bottom-[-10%] right-[-10%] w-96 h-96 bg-brand-tertiary rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000">
            </div>
            <div class="relative z-10 px-12 text-center text-white">
                <div class="mb-6 flex justify-center">
                    <div
                        class="w-24 h-24 bg-white/20 backdrop-blur-lg rounded-3xl flex items-center justify-center shadow-2xl border border-white/30 transform hover:scale-105 transition duration-500">
                        <span class="text-6xl drop-shadow-md">🏥</span>
                    </div>
                </div>
                <h2 class="text-4xl font-extrabold mb-4 tracking-tight drop-shadow-sm">Satu Akun, <br>Seluruh Layanan.
                </h2>
                <p class="text-lg text-white/90 font-medium leading-relaxed max-w-md mx-auto">
                    Akses riwayat medis, jadwal dokter, dan tagihan Anda di seluruh jaringan Klinik Sehat dengan satu
                    identitas aman.
                </p>
            </div>
        </div>

        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 relative bg-white">
            <a href="/"
                class="absolute top-8 left-8 text-gray-400 hover:text-brand-secondary transition flex items-center gap-2 font-medium group">
                <div
                    class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center group-hover:bg-brand-primary/20 transition">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-4 w-4 transform group-hover:-translate-x-1 transition" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </div>
                Kembali ke Beranda
            </a>

            <div class="w-full max-w-md">
                <div class="lg:hidden text-center mb-8">
                    <div
                        class="w-16 h-16 bg-brand-primary/20 rounded-2xl flex items-center justify-center mx-auto mb-3">
                        <span class="text-4xl">🏥</span>
                    </div>
                    <h2 class="text-2xl font-bold text-brand-dark">Klinik Umum Sehat</h2>
                </div>

                <div class="text-left mb-8">
                    <h1 class="text-3xl font-extrabold text-brand-dark mb-2">Selamat Datang! 👋</h1>
                    <p class="text-gray-500">Silakan masukkan informasi Anda untuk membuat akun layanan kesehatan.
                    </p>
                </div>

                @if ($errors->any())
                    <div
                        class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg flex items-start gap-3 animate-pulse shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500 shrink-0" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>
                            <h3 class="text-sm font-bold text-red-800">Pendaftaran Gagal</h3>
                            {{-- TAMPILKAN ERROR ASLI DI SINI --}}
                            <ul class="list-disc list-inside text-sm text-red-600 mt-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
                {{-- Alert Sukses (Tidak diperlukan di form register, tapi saya biarkan untuk konsistensi blade) --}}
                @if (session('success'))
                    <div
                        class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg flex items-start gap-3 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500 shrink-0" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>
                            <h3 class="text-sm font-bold text-green-800">Berhasil</h3>
                            <p class="text-sm text-green-600">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                <form action="{{ route('register') }}" method="POST" class="space-y-5">
                    @csrf

                    {{-- SECTION 1: AKUN LOGIN --}}
                    <p
                        class="text-sm font-bold text-brand-secondary uppercase tracking-widest border-b border-gray-100 pb-2">
                        Informasi Akun</p>

                    {{-- Nama Lengkap --}}
                    <div class="form-control">
                        <label class="label font-bold text-brand-dark">Nama Lengkap</label>
                        <input type="text" name="name" placeholder="Sesuai KTP"
                            class="input input-bordered w-full rounded-xl bg-gray-50 focus:bg-white"
                            value="{{ old('name') }}" required />
                    </div>

                    {{-- Email --}}
                    <div class="form-control">
                        <label class="label font-bold text-brand-dark">Email</label>
                        <input type="email" name="email" placeholder="email@contoh.com"
                            class="input input-bordered w-full rounded-xl bg-gray-50 focus:bg-white"
                            value="{{ old('email') }}" required />
                    </div>

                    {{-- Password & Konfirmasi --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-control">
                            <label class="label font-bold text-brand-dark">Password</label>
                            <input type="password" name="password" placeholder="Min. 8 Karakter"
                                class="input input-bordered w-full rounded-xl bg-gray-50 focus:bg-white" required />
                        </div>
                        <div class="form-control">
                            <label class="label font-bold text-brand-dark">Ulangi Password</label>
                            <input type="password" name="password_confirmation" placeholder="Ketik ulang..."
                                class="input input-bordered w-full rounded-xl bg-gray-50 focus:bg-white" required />
                        </div>
                    </div>

                    {{-- SECTION 2: DATA PRIBADI (WAJIB UNTUK MEDIS) --}}
                    <p
                        class="text-sm font-bold text-brand-secondary uppercase tracking-widest border-b border-gray-100 pb-2 pt-4">
                        Data Pasien</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {{-- NIK --}}
                        <div class="form-control">
                            <label class="label font-bold text-brand-dark">NIK (KTP/KK)</label>
                            <input type="text" name="nik" placeholder="16 Digit" maxlength="16"
                                class="input input-bordered w-full rounded-xl bg-gray-50 focus:bg-white"
                                value="{{ old('nik') }}" required />
                        </div>

                        {{-- No HP --}}
                        <div class="form-control">
                            <label class="label font-bold text-brand-dark">No. WhatsApp</label>
                            <input type="text" name="no_hp" placeholder="08xxxxxxxx"
                                class="input input-bordered w-full rounded-xl bg-gray-50 focus:bg-white"
                                value="{{ old('no_hp') }}" required />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {{-- Tanggal Lahir --}}
                        <div class="form-control">
                            <label class="label font-bold text-brand-dark">Tanggal Lahir</label>
                            <input type="date" name="tgl_lahir"
                                class="input input-bordered w-full rounded-xl bg-gray-50 focus:bg-white"
                                value="{{ old('tgl_lahir') }}" required />
                        </div>

                        {{-- Jenis Kelamin --}}
                        <div class="form-control">
                            <label class="label font-bold text-brand-dark">Jenis Kelamin</label>
                            <select name="jenis_kelamin"
                                class="select select-bordered w-full rounded-xl bg-gray-50 focus:bg-white" required>
                                <option value="" disabled selected>-- Pilih --</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                    </div>

                    {{-- Alamat Domisili --}}
                    <div class="form-control">
                        <label class="label font-bold text-brand-dark">Alamat Domisili</label>
                        <textarea name="alamat_domisili" class="textarea textarea-bordered h-20 rounded-xl bg-gray-50 focus:bg-white"
                            placeholder="Jalan, RT/RW, Kelurahan, Kecamatan..." required>{{ old('alamat_domisili') }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {{-- Golongan Darah --}}
                        <div class="form-control">
                            <label class="label font-bold text-brand-dark">Golongan Darah</label>
                            <select name="golongan_darah"
                                class="select select-bordered w-full rounded-xl bg-gray-50 focus:bg-white">
                                <option value="" selected>Tidak Tahu / -</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="AB">AB</option>
                                <option value="O">O</option>
                            </select>
                        </div>

                        {{-- Riwayat Alergi --}}
                        <div class="form-control">
                            <label class="label font-bold text-brand-dark">Riwayat Alergi</label>
                            <input type="text" name="riwayat_alergi"
                                placeholder="Contoh: Alergi Seafood, Antibiotik..."
                                class="input input-bordered w-full rounded-xl bg-gray-50 focus:bg-white"
                                value="{{ old('riwayat_alergi') }}" />
                            <label class="label">
                                <span class="label-text-alt text-gray-400">Kosongkan jika tidak ada.</span>
                            </label>
                        </div>
                    </div>

                    {{-- TOMBOL DAFTAR --}}
                    <button type="submit"
                        class="btn btn-block bg-brand-secondary hover:bg-brand-dark text-white border-none h-12 rounded-xl text-lg font-bold shadow-lg mt-6">
                        Daftar Sekarang
                    </button>
                </form>

                <div class="text-center pt-6 border-t border-gray-100 mt-8">
                    <p class="text-gray-600 mb-2">Sudah punya akun pasien?</p>
                    {{-- Link ke halaman login --}}
                    <a href="{{ route('login') }}"
                        class="btn btn-outline border-brand-secondary text-brand-secondary hover:bg-brand-secondary hover:text-white hover:border-brand-secondary w-full rounded-xl font-bold transition-all">
                        Masuk Sekarang
                    </a>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
