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
    <!-- Load Resources -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#F8F9FE] text-gray-800 antialiased" style="font-family: 'Poppins', sans-serif" x-data="{ sidebarOpen: false }">

    <div class="flex h-screen overflow-hidden">

        <!-- ============================================================== -->
        <!-- SIDEBAR (MENU UTAMA) -->
        <!-- ============================================================== -->
        <aside
            class="fixed inset-y-0 left-0 z-50 w-72 bg-white border-r border-gray-100 transition-transform duration-300 ease-in-out transform lg:translate-x-0 lg:static lg:inset-0 flex flex-col shadow-[4px_0_24px_rgba(0,0,0,0.02)]"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">

            <!-- 1. LOGO AREA -->
            <div class="h-24 flex items-center px-8 border-b border-gray-50">
                <div class="flex items-center gap-3">
                    <div
                        class="w-10 h-10 bg-brand-dark rounded-xl flex items-center justify-center text-white shadow-lg shadow-brand-dark/20">
                        <span class="text-2xl">🏥</span>
                    </div>
                    <div>
                        <h1 class="text-lg font-bold text-brand-dark leading-tight">SI KLINIK</h1>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Portal Internal</p>
                    </div>
                </div>
            </div>

            <!-- 2. USER PROFILE MINI -->
            <div class="px-6 py-6">
                <div
                    class="p-4 bg-gray-50 rounded-2xl border border-gray-100 flex items-center gap-3 relative group overflow-hidden">
                    <!-- Hiasan Hover Background -->
                    <div
                        class="absolute inset-0 bg-brand-primary/20 translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                    </div>

                    <div class="relative z-10 avatar online">
                        <div class="w-10 h-10 rounded-full ring ring-white">
                            <img
                                src="https://ui-avatars.com/api/?name={{ session('user_data')['staff']['nama'] }}&background=31326F&color=fff" />
                        </div>
                    </div>
                    <div class="relative z-10">
                        <p class="text-sm font-bold text-brand-dark group-hover:text-brand-dark transition-colors">
                            {{ session('user_data')['staff']['nama'] }}</p>
                        <p class="text-xs text-gray-500 font-medium capitalize">{{ session('user_data')['role'] }}</p>
                    </div>
                </div>
            </div>

            <!-- 3. NAVIGATION MENU -->
            <nav class="flex-1 overflow-y-auto px-4 pb-4 space-y-1 no-scrollbar">

                <!-- MENU: DASHBOARD -->
                <a href="/dashboard"
                    class="relative flex items-center gap-3 px-4 py-3.5 rounded-xl group overflow-hidden transition-all duration-300 {{ request()->is('dashboard') ? 'bg-brand-dark text-white shadow-lg shadow-brand-dark/30' : 'text-gray-500 hover:text-brand-dark hover:bg-gray-50' }}">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5 transition-transform duration-300 group-hover:scale-110 {{ request()->is('dashboard') ? 'text-brand-primary' : 'text-gray-400 group-hover:text-brand-dark' }}"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg>
                    <span class="font-semibold text-sm">Dashboard</span>
                    <!-- Active Indicator (Titik) -->
                    @if (request()->is('dashboard'))
                        <span
                            class="absolute right-4 w-2 h-2 rounded-full bg-brand-primary shadow-[0_0_8px_#A8FBD3]"></span>
                    @endif
                </a>

                <!-- SECTION TITLE -->
                <div class="pt-6 pb-3 px-4">
                    <p class="text-[10px] font-extrabold text-gray-400 uppercase tracking-widest">Front Office</p>
                </div>

                <!-- MENU: ANTRIAN (Hijau) -->
                <a href="{{ route('admin.jadwal-dokter') }}"
                    class="relative flex items-center gap-3 px-4 py-3.5 rounded-xl group overflow-hidden transition-all duration-300 {{ request()->routeIs('admin.jadwal-dokter') ? 'bg-brand-secondary text-white shadow-lg shadow-brand-secondary/30' : 'text-gray-500 hover:bg-brand-secondary/10 hover:text-brand-secondary' }}">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5 transition-transform duration-300 group-hover:-rotate-12 {{ request()->routeIs('admin.jadwal-dokter') ? 'text-white' : 'text-gray-400 group-hover:text-brand-secondary' }}"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <span class="font-semibold text-sm">Jadwal Dokter</span>
                </a>

                <!-- SECTION TITLE -->
                <div class="pt-4 pb-3 px-4">
                    <p class="text-[10px] font-extrabold text-gray-400 uppercase tracking-widest">Medis & Dokter</p>
                </div>

                <!-- MENU: REKAM MEDIS (Ungu/Brand Btn) -->
                <a href="/medical-records"
                    class="relative flex items-center gap-3 px-4 py-3.5 rounded-xl group overflow-hidden transition-all duration-300 {{ request()->is('medical-records*') ? 'bg-brand-btn text-white shadow-lg shadow-brand-btn/30' : 'text-gray-500 hover:bg-brand-btn/10 hover:text-brand-btn' }}">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5 transition-transform duration-300 group-hover:translate-x-1 {{ request()->is('medical-records*') ? 'text-white' : 'text-gray-400 group-hover:text-brand-btn' }}"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span class="font-semibold text-sm">Rekam Medis</span>
                </a>

                <!-- SECTION TITLE -->
                <div class="pt-4 pb-3 px-4">
                    <p class="text-[10px] font-extrabold text-gray-400 uppercase tracking-widest">Keuangan</p>
                </div>

                <!-- MENU: KASIR (Kuning/Orange) -->
                <a href="#"
                    class="relative flex items-center gap-3 px-4 py-3.5 rounded-xl group overflow-hidden transition-all duration-300 {{ request()->is('invoices*') ? 'bg-orange-500 text-white shadow-lg shadow-orange-500/30' : 'text-gray-500 hover:bg-orange-500/10 hover:text-orange-500' }}">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5 transition-transform duration-300 group-hover:scale-110 {{ request()->is('invoices*') ? 'text-white' : 'text-gray-400 group-hover:text-orange-500' }}"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="font-semibold text-sm">Pembayaran</span>
                </a>



                <!-- SEPARATOR -->
                <div class="my-4 border-t border-gray-100"></div>

                <!-- MENU: MASTER (Abu-abu) -->
                <a href="{{ route('admin.rujukan-digital') }}"
                    class="relative flex items-center gap-3 px-4 py-3.5 rounded-xl group overflow-hidden transition-all duration-300 {{ request()->routeIs('admin.rujukan-digital') ? 'bg-sky-800 text-white shadow-lg shadow-sky-500/30' : 'text-gray-500 hover:bg-sky-100 hover:text-sky-900' }}">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"
                        xmlns="http://www.w3.org/2000/svg"
                        class="transition-transform duration-300 opacity-50 group-hover:scale-110 {{ request()->routeIs('admin.rujukan-digital') ? 'text-white' : 'text-gray-400 group-hover:text-sky-900' }}">
                        <path
                            d="M4 4H20C21.1 4 22 4.9 22 6V18C22 19.1 21.1 20 20 20H4C2.9 20 2 19.1 2 18V6C2 4.9 2.9 4 4 4Z"
                            stroke="#25282B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M22 6L12 13L2 6" stroke="#25282B" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                    <span class="font-semibold text-sm">Rujukan Digital
                    </span>
                </a>
            </nav>

            <!-- 4. LOGOUT BUTTON -->
            <div class="p-4 border-t border-gray-100 ">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="flex items-center justify-center gap-2 w-full px-4 py-3 rounded-xl border border-red-100 text-red-500 hover:bg-red-500 hover:text-white transition-all duration-300 group shadow-sm hover:shadow-red-500/20">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5 transition-transform duration-300 group-hover:-translate-x-1"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span class="font-bold text-sm">Keluar Sistem</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- ============================================================== -->
        <!-- MAIN CONTENT AREA -->
        <!-- ============================================================== -->
        <div class="flex-1 flex flex-col h-screen relative">

            <!-- Mobile Header (Hamburger) -->
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

            <!-- Content -->
            <main class="flex-1 overflow-y-auto p-6 lg:p-10 bg-[#F8F9FE]">
                @yield('content')
            </main>

            <!-- Overlay for Mobile Sidebar -->
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
