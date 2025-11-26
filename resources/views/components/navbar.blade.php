<div class="navbar bg-base-100 shadow-sm px-10 bg-navbar">
    <div class="navbar-start">
        <div class="dropdown">
            <div tabindex="0" role="button" class="btn btn-ghost lg:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" />
                </svg>
            </div>
            <ul tabindex="-1" class="menu menu-sm dropdown-content bg-base-100 rounded-box z-1 mt-3 w-52 p-2 shadow">
                <li><a>Item 1</a></li>
                <li>
                    <a>Parent</a>
                    <ul class="p-2">
                        <li><a>Submenu 1</a></li>
                        <li><a>Submenu 2</a></li>
                    </ul>
                </li>
                <li><a>Item 3</a></li>
            </ul>
        </div>
        <a class="font-semibold text-xl text-navbar">KlinikR1</a>
    </div>
    <div class="navbar-center hidden lg:flex">
        <ul class="menu menu-horizontal px-1 gap-3">
            <li><a class="text-navbar hover:bg-transparent active:bg-transparent">Beranda
                    <span class="absolute bottom-1 "></span>
                </a></li>
            <li><a class="text-navbar hover:bg-transparent active:bg-transparent">Cari Dokter
                    <span class="absolute bottom-1 "></span>
                </a></li>
            <li><a class="text-navbar hover:bg-transparent active:bg-transparent">Fasilitas & Layanan
                    <span class="absolute bottom-1 "></span>
                </a></li>
            <li><a class="text-navbar hover:bg-transparent active:bg-transparent">Riwayat Reservasi
                    <span class="absolute bottom-1 "></span>
                </a></li>
        </ul>
    </div>
    <div class="navbar-end">
        @guest
            <a href="{{ route('login') }}" class="px-2 py-1 bg-green-500/70 font-semibold text-green-900 rounded-lg shadow-md hover:-translate-y-px hover:shadow-md hover:shadow-green-500/50 transition-all duration-200">Login</a>
        @endguest
        @auth
            {{-- Jika user dah login --}}
        @endauth
    </div>
</div>
