<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Portal - Klinik Sehat</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#F8F9FE] text-gray-800 antialiased" style="font-family: 'Poppins', sans-serif" x-data="{ sidebarOpen: false }">

    <div class="flex h-screen overflow-hidden">

        <aside
            class="fixed inset-y-0 left-0 z-50 w-72 bg-brand-dark text-white transition-transform duration-300 ease-in-out transform lg:translate-x-0 lg:static lg:inset-0 shadow-2xl flex flex-col"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">

            <div
                class="flex items-center justify-center h-20 border-b border-white/10 bg-brand-dark/50 backdrop-blur-sm">
                <div class="flex items-center gap-3">
                    <div
                        class="w-10 h-10 bg-gradient-to-br from-brand-primary to-brand-secondary rounded-xl flex items-center justify-center shadow-lg shadow-brand-primary/20">
                        <span class="text-2xl">🏥</span>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold tracking-wide text-white">Klinik Sehat</h1>
                        <p class="text-xs text-brand-secondary uppercase tracking-widest font-semibold">Portal Internal
                        </p>
                    </div>
                </div>
            </div>

            @php
                $staff = session('user_data')['staff'] ?? null;
                $nama = $staff['nama_lengkap'] ?? 'Staff Klinik';
                $role = $staff['peran'] ?? 'guest'; // dokter, perawat, dll
            @endphp

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

                {{-- A. ADMIN --}}
                @if ($role == 'admin')
                    <p class="px-4 text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 mt-2">Administrator</p>

                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 text-gray-400 hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.dashboard') ? 'bg-brand-btn text-white' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6z" />
                        </svg>
                        <span class="font-medium">Dashboard Admin</span>
                    </a>

                    {{-- Admin juga bisa lihat menu staff lain --}}
                    <div class="my-4 border-t border-white/5"></div>
                @endif

                {{-- B. RESEPSIONIS (Front Office) --}}
                @if (in_array($role, ['resepsionis', 'admin']))
                    <a href="{{ route('staff.resepsionis') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('staff.resepsionis') ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/50' : 'text-gray-400 hover:bg-white/10 hover:text-blue-400' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5" />
                        </svg>
                        <span class="font-medium">Antrian Masuk</span>
                    </a>
                @endif

                {{-- C. PERAWAT (Keperawatan) --}}
                @if (in_array($role, ['perawat', 'admin']))
                    <a href="{{ route('staff.perawat') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('staff.perawat') ? 'bg-yellow-500 text-white shadow-lg shadow-yellow-900/50' : 'text-gray-400 hover:bg-white/10 hover:text-yellow-400' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                        <span class="font-medium">Pemeriksaan Awal</span>
                    </a>
                @endif

                {{-- D. DOKTER (Ruang Praktik) --}}
                @if (in_array($role, ['dokter', 'admin']))
                    <a href="{{ route('staff.dokter') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('staff.dokter') ? 'bg-purple-600 text-white shadow-lg shadow-purple-900/50' : 'text-gray-400 hover:bg-white/10 hover:text-purple-400' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                        </svg>
                        <span class="font-medium">Ruang Praktik</span>
                    </a>
                @endif

                {{-- E. KASIR (Keuangan) --}}
                @if (in_array($role, ['kasir', 'admin']))
                    <a href="{{ route('staff.kasir') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('staff.kasir') ? 'bg-green-600 text-white shadow-lg shadow-green-900/50' : 'text-gray-400 hover:bg-white/10 hover:text-green-400' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span class="font-medium">Kasir</span>
                    </a>
                @endif

            </nav>

            <div class="p-4 border-t border-white/5 bg-brand-dark/50">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="flex items-center justify-center gap-3 w-full px-4 py-3 rounded-xl text-red-400 bg-red-500/10 hover:bg-red-500 hover:text-white transition-all duration-200 group border border-red-500/20">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5 group-hover:scale-110 transition-transform" fill="none"
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
                <span class="text-xl font-bold text-brand-dark">Klinik Sehat</span>
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
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            </div>
        </div>

    </div>

</body>

</html>
