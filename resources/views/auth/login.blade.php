<!DOCTYPE html>
<html lang="id" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk ke Portal Pasien - Klinik Umum Sehat</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="font-sans antialiased text-gray-900">

    <div class="min-h-screen flex bg-white" x-data="{ showPassword: false }">
        <div class="hidden lg:flex w-1/2 relative bg-brand-secondary overflow-hidden items-center justify-center">
            <div class="absolute inset-0">
                <img src="https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80"
                    alt="Klinik Hospital" class="w-full h-full object-cover opacity-20 mix-blend-overlay">
            </div>
            <div
                class="absolute inset-0 bg-linear-to-br from-brand-secondary/90 via-brand-secondary/80 to-brand-primary/40">
            </div>
            <div
                class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-brand-primary rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob">
            </div>
            <div
                class="absolute bottom-[-10%] right-[-10%] w-96 h-96 bg-brand-tertiary rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000">
            </div>
            <!-- Konten Text -->
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

        <!-- BAGIAN KANAN: Form Login -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 relative bg-white">
            <!-- Tombol Balik -->
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
                <!-- Header Mobile Only -->
                <div class="lg:hidden text-center mb-8">
                    <div
                        class="w-16 h-16 bg-brand-primary/20 rounded-2xl flex items-center justify-center mx-auto mb-3">
                        <span class="text-4xl">🏥</span>
                    </div>
                    <h2 class="text-2xl font-bold text-brand-dark">Klinik Umum Sehat</h2>
                </div>

                <div class="text-left mb-8">
                    <h1 class="text-3xl font-extrabold text-brand-dark mb-2">Selamat Datang Kembali 👋</h1>
                    <p class="text-gray-500">Silakan masukkan kredensial Anda untuk melanjutkan akses layanan kesehatan.
                    </p>
                </div>

                <!-- Alert Error -->
                @if ($errors->any())
                    <div
                        class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg flex items-start gap-3 animate-pulse shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500 shrink-0" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>
                            <h3 class="text-sm font-bold text-red-800">Login Gagal</h3>
                            <p class="text-sm text-red-600">{{ $errors->first() }}</p>
                        </div>
                    </div>
                @endif

                <!-- Alert Sukses -->
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

                <!-- Form -->
                <form action="{{ route('login') }}" method="POST" class="space-y-5">
                    @csrf
                    <div class="form-control group">
                        <label class="label pl-0">
                            <span
                                class="label-text font-bold text-brand-dark group-focus-within:text-brand-secondary transition text-base">Email
                                Address</span>
                        </label>
                        <div class="relative">
                            <!-- Icon SVG: Tambahkan z-10 biar di atas input -->
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none z-10">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5 text-gray-400 group-focus-within:text-brand-secondary transition"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <input type="email" name="email" placeholder="nama@email.com"
                                class="input input-bordered w-full pl-12 h-12 rounded-xl border-gray-300 focus:border-brand-secondary focus:ring-4 focus:ring-brand-secondary/10 transition-all bg-gray-50 focus:bg-white text-base shadow-sm"
                                value="{{ old('email') }}" required autofocus />
                        </div>
                    </div>

                    <!-- Input Password (Dengan Toggle Show/Hide) -->
                    <div class="form-control group">
                        <label class="label pl-0 flex justify-between">
                            <span
                                class="label-text font-bold text-brand-dark group-focus-within:text-brand-secondary transition text-base">Password</span>
                            <a href="#"
                                class="label-text-alt link link-hover text-brand-secondary font-medium hover:text-brand-dark transition">Lupa
                                Password?</a>
                        </label>
                        <div class="relative">
                            <!-- Icon Gembok -->
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none z-10">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5 text-gray-400 group-focus-within:text-brand-secondary transition"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>

                            <!-- Input -->
                            <input :type="showPassword ? 'text' : 'password'" name="password" placeholder="••••••••"
                                class="input input-bordered w-full pl-12 pr-12 h-12 rounded-xl border-gray-300 focus:border-brand-secondary focus:ring-4 focus:ring-brand-secondary/10 transition-all bg-gray-50 focus:bg-white text-base shadow-sm"
                                required />

                            <!-- Tombol Mata (Eye Icon) -->
                            <button type="button" @click="showPassword = !showPassword"
                                class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-brand-dark transition cursor-pointer z-10 focus:outline-none">
                                <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg x-show="showPassword" style="display: none;" xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 011.575-3.175M7.5 7.5l9 9" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10.73 5.08A10.05 10.05 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.05 10.05 0 01-1.575 3.175" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Ingat Saya -->
                    <div class="flex items-center pt-2">
                        <label class="label cursor-pointer justify-start gap-3 pl-0 hover:opacity-80 transition">
                            <input type="checkbox" name="remember"
                                class="checkbox checkbox-sm rounded border-gray-300 text-white focus:ring-brand-secondary checked:bg-brand-secondary checked:border-brand-secondary" />
                            <span class="label-text text-gray-600 font-medium">Ingat saya di perangkat ini</span>
                        </label>
                    </div>

                    <button type="submit"
                        class="btn btn-block bg-brand-secondary hover:bg-brand-dark text-white border-none h-12 rounded-xl text-lg font-bold shadow-lg shadow-brand-secondary/30 hover:shadow-brand-secondary/50 transition-all transform hover:-translate-y-1 mt-4">
                        Masuk Sekarang
                    </button>
                </form>

                <div class="text-center pt-6 border-t border-gray-100">
                    <p class="text-gray-600 mb-2">Belum punya akun pasien?</p>
                    <a href="{{ route('register') }}"
                        class="btn btn-outline border-brand-secondary text-brand-secondary hover:bg-brand-secondary hover:text-white hover:border-brand-secondary w-full rounded-xl font-bold transition-all">
                        Daftar Akun Baru
                    </a>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
