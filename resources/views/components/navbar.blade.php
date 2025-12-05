<div class="navbar fixed bg-base-100 shadow-sm px-4 md:px-10 bg-navbar z-50">
    <div class="navbar-start">
        <div class="dropdown">
            <div tabindex="0" role="button" class="btn btn-ghost btn-sm lg:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" />
                </svg>
            </div>
            <ul tabindex="-1" class="menu menu-sm dropdown-content bg-base-100 rounded-box z-1 mt-3 w-52 p-2 shadow">
                <li><a href="{{ route('beranda') }}">Beranda</a></li>
                <li><a href="{{ route('cari_dokter') }}">Cari Dokter</a></li>
                <li><a href="{{ route('pasien.fasilitas-layanan') }}">Fasilitas & Layanan</a></li>
                <li><a href="{{ route('riwayat_reservasi') }}">Riwayat Reservasi</a></li>
            </ul>
        </div>
        <a class="font-semibold text-lg md:text-xl text-navbar">SI-Klinik</a>
    </div>
    
    <div class="navbar-center hidden lg:flex">
        <ul class="menu menu-horizontal px-1 gap-3">
            <li><a href="{{ route('beranda') }}"
                    class="font-semibold text-transparent bg-clip-text bg-linear-to-r from-(--bg-secondary) text-navbar to-black/80 bg-size-[200%_auto] bg-right transition-all duration-300 ease-out hover:bg-left relative group px-3 py-2">
                    Beranda
                    <span class="absolute bottom-1.5 left-0 w-full h-0.5 bg-linear-to-r from-(--bg-primary) to-(--bg-secondary) {{ request()->routeIs('beranda') ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }} transition-transform duration-300 ease-out origin-left"></span>
                </a></li>
            <li><a href="{{ route('cari_dokter') }}"
                    class="font-semibold text-transparent bg-clip-text bg-linear-to-r from-(--bg-secondary) text-navbar to-black/80 bg-size-[200%_auto] bg-right transition-all duration-300 ease-out hover:bg-left relative group px-3 py-2">
                    Cari Dokter
                    <span class="absolute bottom-1.5 left-0 w-full h-0.5 bg-linear-to-r from-(--bg-primary) to-(--bg-secondary) {{ request()->routeIs('cari_dokter') || request()->routeIs('profil_dokter') ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }} transition-transform duration-300 ease-out origin-left"></span>
                </a></li>
            <li><a href="{{ route('pasien.fasilitas-layanan') }}"
                    class="font-semibold text-transparent bg-clip-text bg-linear-to-r from-(--bg-secondary) text-navbar to-black/80 bg-size-[200%_auto] bg-right transition-all duration-300 ease-out hover:bg-left relative group px-3 py-2">
                    Fasilitas & Layanan
                    <span class="absolute bottom-1.5 left-0 w-full h-0.5 bg-linear-to-r from-(--bg-primary) to-(--bg-secondary) {{ request()->routeIs('pasien.fasilitas-layanan') || request()->routeIs('layanan.*') || request()->routeIs('fasilitas.*') || request()->routeIs('fasilitas-layanan.*') ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }} transition-transform duration-300 ease-out origin-left"></span>
                </a></li>
            <li><a href="{{ route('riwayat_reservasi') }}"
                    class="font-semibold text-transparent bg-clip-text bg-linear-to-r from-(--bg-secondary) text-navbar to-black/80 bg-size-[200%_auto] bg-right transition-all duration-300 ease-out hover:bg-left relative group px-3 py-2">
                    Riwayat Reservasi
                    <span class="absolute bottom-1.5 left-0 w-full h-0.5 bg-linear-to-r from-(--bg-primary) to-(--bg-secondary) {{ request()->routeIs('riwayat_reservasi') || request()->routeIs('tiket_antrian') || request()->routeIs('booking.store') ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }} transition-transform duration-300 ease-out origin-left"></span>
                </a></li>
        </ul>
    </div>
    
    <div class="navbar-end gap-2 md:gap-3">
    @php
        $isLoggedIn = session()->has('api_token');
        $userData = session('user_data') ?? [];
        $role = $userData['role'] ?? 'guest';

        $nama = match ($role) {
            'staff' => $userData['staff']['nama_lengkap'] ?? 'Staff',
            'pasien' => $userData['pasien']['nama_lengkap'] ?? 'Pasien',
            default => 'Tamu',
        };
        $initial = strtoupper(substr($nama, 0, 1));
    @endphp

    @if ($isLoggedIn)
        <div class="dropdown dropdown-end">
            <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar btn-sm md:btn-md">
                <div class="w-8 md:w-10 rounded-full ring ring-brand-secondary ring-offset-base-100 ring-offset-2">
                    <div class="bg-brand-secondary text-neutral-content flex items-center justify-center w-full h-full font-bold text-sm md:text-base">
                        {{ strtoupper(substr($nama, 0, 2)) }}
                    </div>
                </div>
            </div>

            <ul tabindex="0" class="menu menu-sm md:menu-md dropdown-content bg-base-100 rounded-box z-[1] mt-3 w-52 md:w-64 p-2 shadow-lg border border-base-200">
                <div class="px-4 py-2 border-b border-base-200 mb-2">
                    <div class="flex flex-col gap-0.5">
                        <span class="text-sm md:text-base font-bold text-base-content">{{ $nama }}</span>
                    </div>
                </div>

                @if ($role == 'staff')
                    <li>
                        <a href="{{ route('staff.dashboard') }}" class="active:bg-primary active:text-white text-sm md:text-base">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                            </svg>
                            Portal Staff
                            <span class="badge badge-xs badge-info">New</span>
                        </a>
                    </li>
                @endif

                <div class="divider my-1"></div>

                <li>
                    <form action="{{ route('logout') }}" method="post" class="w-full py-1">
                        @csrf
                        <button type="submit" class="flex w-full items-center gap-2 text-sm md:text-base text-error hover:cursor-pointer active:text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 22 22" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    @else
        <div class="flex items-center gap-1 md:gap-2">
            <a href="{{ route('register') }}" class="btn btn-ghost btn-sm md:btn-md text-xs md:text-base text-base-content/70 rounded-full hover:text-base-content hover:bg-base-200 transition-all duration-300">
                Daftar
            </a>
            <a href="{{ route('login') }}" class="btn bg-brand-secondary text-cyan-50 btn-sm md:btn-md text-xs md:text-base px-3 md:px-5 rounded-full shadow-md hover:shadow-lg hover:bg-opacity-90 hover:scale-105 transition-all duration-300 ease-out">
                Login
            </a>
        </div>
    @endif
</div>
</div>
