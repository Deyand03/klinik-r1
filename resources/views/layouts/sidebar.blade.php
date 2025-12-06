<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Staff - Klinik Sehat</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#F8F9FE] text-gray-800 antialiased" style="font-family: 'Poppins', sans-serif" x-data="{ sidebarOpen: false }">

    {{-- 🔥 DEFINISI VARIABEL DI SINI (PALING ATAS) AGAR TIDAK ERROR --}}
    @php
        $userData = session('user_data') ?? [];

        // Cek apakah data staff ada?
        if (isset($userData['staff'])) {
            $nama = $userData['staff']['nama_lengkap'];
            $role = $userData['staff']['peran'];
        } else {
            // Fallback (Jaga-jaga kalau session hilang / admin murni)
            $nama = $userData['name'] ?? 'User Tamu';
            $role = 'guest';
        }
    @endphp

    <div class="flex h-screen overflow-hidden">

        <aside
            class="fixed inset-y-0 left-0 z-50 w-72 bg-brand-dark text-white transition-transform duration-300 ease-in-out transform lg:translate-x-0 lg:static lg:inset-0 shadow-2xl flex flex-col"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">

            <div
                class="flex items-center justify-center h-20 border-b border-white/10 bg-brand-dark/50 backdrop-blur-sm">
                <div class="flex items-center gap-3">
                    <div
                        class="w-10 h-10 bg-linear-to-br from-brand-primary to-brand-secondary rounded-xl flex items-center justify-center shadow-lg shadow-brand-primary/20">
                        <span class="text-2xl">🏥</span>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold tracking-wide text-white">Klinik Sehat</h1>
                        <p class="text-xs text-brand-secondary uppercase tracking-widest font-semibold">Portal Staff</p>
                    </div>
                </div>
            </div>

            <div class="p-6 border-b border-white/5">
                <div class="flex items-center gap-4">
                    <div class="avatar online">
                        <div
                            class="w-12 h-12 rounded-full ring-2 ring-brand-primary ring-offset-2 ring-offset-brand-dark">
                            <img
                                src="https://ui-avatars.com/api/?name={{ urlencode($nama) }}&background=A8FBD3&color=31326F" />
                        </div>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-white w-32 truncate">{{ $nama }}</p>
                        <span
                            class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-white/10 text-brand-secondary border border-brand-secondary/30">
                            {{ $role }}
                        </span>
                    </div>
                </div>
            </div>

            <nav class="flex-1 overflow-y-auto py-6 px-4 space-y-2 custom-scrollbar">

                {{-- DASHBOARD STAFF (Menu Utama) --}}
                @php
                    // Tentukan kondisi "aktif" berdasarkan peran dan pola route yang umum
                    if ($role == 'resepsionis') {
                        $isActive =
                            request()->routeIs('resepsionis.*') ||
                            request()->is('antrian*') ||
                            request()->routeIs('staff.dashboard');
                    } elseif ($role == 'perawat') {
                        $isActive =
                            request()->routeIs('perawat.*') ||
                            request()->is('pemeriksaan*') ||
                            request()->routeIs('staff.dashboard');
                    } elseif ($role == 'dokter') {
                        $isActive =
                            request()->routeIs('dokter.*') ||
                            request()->is('praktik*') ||
                            request()->routeIs('staff.dashboard');
                    } elseif ($role == 'kasir') {
                        $isActive =
                            request()->routeIs('kasir.*') ||
                            request()->is('pembayaran*') ||
                            request()->routeIs('staff.dashboard');
                    } else {
                        $isActive = request()->routeIs('staff.dashboard');
                    }
                @endphp

                <a href="{{ route('staff.dashboard') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ $isActive ? 'bg-brand-btn text-white shadow-lg shadow-brand-btn/20' : 'text-gray-400 hover:bg-white/10 hover:text-white' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6z" />
                    </svg>
                    <span class="font-medium">
                        @if ($role == 'resepsionis')
                            Antrian Masuk
                        @elseif($role == 'perawat')
                            Pemeriksaan Awal
                        @elseif($role == 'dokter')
                            Ruang Praktik
                        @elseif($role == 'kasir')
                            Pembayaran
                        @else
                            Dashboard
                        @endif
                    </span>
                </a>

                @if ($role == 'resepsionis')
                    {{-- 2. Atur Jadwal Dokter --}}
                    <a href="{{ route('staff.register-pasien') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('staff.register-pasien') ? 'bg-brand-btn text-white shadow-lg shadow-brand-btn/20' : 'text-gray-400 hover:bg-white/10 hover:text-white' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span class="font-medium">Register Pasien</span>
                    </a>
                @endif



                {{-- KHUSUS ADMIN (Menu Utama Tambahan) --}}
                @if ($role == 'admin')
                    {{-- 1. Riwayat Pasien ALL --}}
                    <a href="{{ route('admin.riwayat') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('admin.riwayat') ? 'bg-brand-btn text-white shadow-lg shadow-brand-btn/20' : 'text-gray-400 hover:bg-white/10 hover:text-white' }}">
                        {{-- Ikon Jam / History --}}
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="font-medium">Riwayat Kunjungan</span>
                    </a>
                    {{-- 2. Atur Jadwal Dokter --}}
                    <a href="{{ route('admin.jadwal-dokter.index') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('admin.jadwal-dokter.index') || request()->routeIs('admin.jadwal-dokter.create') || request()->routeIs('admin.jadwal-dokter.edit') ? 'bg-brand-btn text-white shadow-lg shadow-brand-btn/20' : 'text-gray-400 hover:bg-white/10 hover:text-white' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span class="font-medium">Atur Jadwal Dokter</span>
                    </a>

                    {{-- 3. Kelola Pegawai --}}
                    <a href="{{ route('admin.staff.index') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('admin.staff.index') || request()->routeIs('admin.staff.create') || request()->routeIs('admin.staff.edit') ? 'bg-brand-btn text-white shadow-lg shadow-brand-btn/20' : 'text-gray-400 hover:bg-white/10 hover:text-white' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span class="font-medium">Kelola Pegawai</span>
                    </a>
                @endif

            </nav>

            <div class="p-4 border-t border-white/5 bg-brand-dark/50">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="flex items-center justify-center gap-3 w-full px-4 py-3 rounded-xl text-red-400 bg-red-500/10 hover:bg-red-500 hover:text-white transition-all duration-200 group border border-red-500/20">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5 transition-transform duration-300 group-hover:-translate-x-1" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span class="font-bold text-sm">Keluar Sistem</span>
                    </button>
                </form>
            </div>
        </aside>

        <div class="flex-1 flex flex-col h-screen relative">
            <header
                class="lg:hidden h-16 bg-white border-b border-gray-100 flex items-center justify-between px-4 z-40">
                <span class="text-xl font-bold text-brand-dark">KlinikR1</span>
                <button @click="sidebarOpen = !sidebarOpen"
                    class="p-2 rounded-lg bg-gray-100 text-gray-600 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </header>
            <main class="flex-1 overflow-y-auto p-6 lg:p-10 bg-[#F8F9FE]">
                @yield('content')
            </main>
            <div x-show="sidebarOpen" @click="sidebarOpen = false"
                class="fixed inset-0 z-40 bg-brand-dark/50 backdrop-blur-sm lg:hidden"
                x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
        </div>

    </div>
</body>

</html>
