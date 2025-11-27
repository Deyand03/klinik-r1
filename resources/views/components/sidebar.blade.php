<aside class="fixed inset-y-0 left-0 z-50 w-72 bg-brand-dark text-white transition-transform duration-300 ease-in-out transform lg:translate-x-0 lg:static lg:inset-0 shadow-2xl flex flex-col"
       :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">

    <!-- 1. HEADER: Logo & Brand -->
    <div class="flex items-center justify-center h-20 border-b border-white/10 bg-brand-dark/50 backdrop-blur-sm">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-gradient-to-br from-brand-primary to-brand-secondary rounded-xl flex items-center justify-center shadow-lg shadow-brand-primary/20">
                <span class="text-2xl">🏥</span>
            </div>
            <div>
                <h1 class="text-xl font-bold tracking-wide text-white">Klinik Sehat</h1>
                <p class="text-xs text-brand-secondary uppercase tracking-widest font-semibold">Admin Portal</p>
            </div>
        </div>
    </div>

    <!-- 2. USER PROFILE (Mini) -->
    <div class="p-6 border-b border-white/5">
        <div class="flex items-center gap-4">
            <div class="avatar online">
                <div class="w-12 h-12 rounded-full ring-2 ring-brand-primary ring-offset-2 ring-offset-brand-dark">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Admin') }}&background=A8FBD3&color=31326F" />
                </div>
            </div>
            <div>
                <p class="text-sm font-bold text-white">{{ Auth::user()->name ?? 'Administrator' }}</p>
                <p class="text-xs text-gray-400 capitalize">{{ Auth::user()->role ?? 'Staff' }}</p>
            </div>
        </div>
    </div>

    <!-- 3. MENU NAVIGATION (Scrollable) -->
    <nav class="flex-1 overflow-y-auto py-6 px-4 space-y-1 custom-scrollbar">

        <!-- DASHBOARD -->
        <a href="/dashboard"
           class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->is('dashboard') ? 'bg-brand-btn text-white shadow-lg shadow-brand-btn/30' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ request()->is('dashboard') ? 'text-white' : 'text-gray-500 group-hover:text-brand-primary' }} transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
            <span class="font-medium">Dashboard</span>
        </a>

        <!-- GROUP: OPERASIONAL -->
        <div class="pt-6 pb-2">
            <p class="px-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Front Office</p>
        </div>

        {{-- Modul 7: Pendaftaran & Antrian --}}
        <a href="/queue"
           class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->is('queue*') ? 'bg-gradient-to-r from-brand-secondary/20 to-transparent border-l-4 border-brand-secondary text-white' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ request()->is('queue*') ? 'text-brand-secondary' : 'text-gray-500 group-hover:text-brand-secondary' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
            <span class="font-medium">Antrian Pasien</span>
            @if(rand(0,1)) <span class="ml-auto bg-brand-btn text-white py-0.5 px-2 rounded-md text-xs font-bold">5</span> @endif
        </a>

        <!-- GROUP: MEDIS -->
        <div class="pt-4 pb-2">
            <p class="px-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Pelayanan Medis</p>
        </div>

        {{-- Modul 4, 5, 6: Rekam Medis (Dokter) --}}
        <a href="/medical-records"
           class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->is('medical-records*') ? 'bg-gradient-to-r from-brand-primary/20 to-transparent border-l-4 border-brand-primary text-white' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ request()->is('medical-records*') ? 'text-brand-primary' : 'text-gray-500 group-hover:text-brand-primary' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
            <span class="font-medium">Rekam Medis</span>
        </a>

        <!-- GROUP: KEUANGAN & FARMASI -->
        <div class="pt-4 pb-2">
            <p class="px-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Keuangan & Farmasi</p>
        </div>

        {{-- Modul 8: Kasir --}}
        <a href="/invoices"
           class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->is('invoices*') ? 'bg-gradient-to-r from-yellow-400/20 to-transparent border-l-4 border-yellow-400 text-white' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ request()->is('invoices*') ? 'text-yellow-400' : 'text-gray-500 group-hover:text-yellow-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            <span class="font-medium">Kasir / Pembayaran</span>
        </a>

        {{-- Modul 10: Farmasi --}}
        <a href="/medicines"
           class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->is('medicines*') ? 'bg-gradient-to-r from-pink-400/20 to-transparent border-l-4 border-pink-400 text-white' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ request()->is('medicines*') ? 'text-pink-400' : 'text-gray-500 group-hover:text-pink-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>
            <span class="font-medium">Stok Obat</span>
        </a>

        <!-- GROUP: PENGATURAN -->
        <div class="pt-4 pb-2">
            <p class="px-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Master Data</p>
        </div>

        {{-- Modul 9: Master Data --}}
        <a href="/master/staff" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group hover:bg-white/5 text-gray-400 hover:text-white">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
            <span class="font-medium">Data Pegawai</span>
        </a>
        <a href="/master/schedules" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group hover:bg-white/5 text-gray-400 hover:text-white">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
            <span class="font-medium">Jadwal Praktek</span>
        </a>

    </nav>

    <!-- 4. LOGOUT (Bottom) -->
    <div class="p-4 border-t border-white/5 bg-brand-dark/50">
        <form method="POST" action="/logout">
            @csrf
            <button type="submit" class="flex items-center gap-3 w-full px-4 py-3 rounded-xl text-red-400 hover:bg-red-500/10 hover:text-red-300 transition-all duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                <span class="font-bold">Keluar</span>
            </button>
        </form>
    </div>
</aside>
