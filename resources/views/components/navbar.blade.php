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
        <a class="font-semibold text-xl text-navbar">SI-Klinik</a>
    </div>
    <div class="navbar-center hidden lg:flex">
        <ul class="menu menu-horizontal px-1 gap-3">
            <li><a href="{{ route('beranda') }}"
                    class="font-semibold text-transparent bg-clip-text bg-linear-to-r from-(--bg-secondary) text-navbar to-black/80 bg-size-[200%_auto] bg-right transition-all duration-300 ease-out hover:bg-left relative group px-3 py-2">
                    Beranda
                    <span
                        class="absolute bottom-1.5 left-0 w-full h-0.5 bg-linear-to-r from-(--bg-primary) to-(--bg-secondary) {{ request()->routeIs('beranda') ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }} transition-transform duration-300 ease-out origin-left"></span>
                    </span>
                </a></li>
            <li><a href="#"
                    class="font-semibold text-transparent bg-clip-text bg-linear-to-r from-(--bg-secondary) text-navbar to-black/80 bg-size-[200%_auto] bg-right transition-all duration-300 ease-out hover:bg-left relative group px-3 py-2">
                    Cari Dokter
                    <span
                        class="absolute bottom-1.5 left-0 w-full h-0.5 bg-linear-to-r from-(--bg-primary) to-(--bg-secondary) scale-x-0 group-hover:scale-x-100 transition-transform duration-300 ease-out origin-left"></span>
                    </span>
                </a></li>
            <li><a href="#"
                    class="font-semibold text-transparent bg-clip-text bg-linear-to-r from-(--bg-secondary) text-navbar to-black/80 bg-size-[200%_auto] bg-right transition-all duration-300 ease-out hover:bg-left relative group px-3 py-2">
                    Fasilitas & Layanan
                    <span
                        class="absolute bottom-1.5 left-0 w-full h-0.5 bg-linear-to-r from-(--bg-primary) to-(--bg-secondary) scale-x-0 group-hover:scale-x-100 transition-transform duration-300 ease-out origin-left"></span>
                    </span>
                </a></li>
            <li><a href="#"
                    class="font-semibold text-transparent bg-clip-text bg-linear-to-r from-(--bg-secondary) text-navbar to-black/80 bg-size-[200%_auto] bg-right transition-all duration-300 ease-out hover:bg-left relative group px-3 py-2">
                    Riwayat Reservasi
                    <span
                        class="absolute bottom-1.5 left-0 w-full h-0.5 bg-linear-to-r from-(--bg-primary) to-(--bg-secondary) scale-x-0 group-hover:scale-x-100 transition-transform duration-300 ease-out origin-left"></span>
                    </span>
                </a></li>
        </ul>
    </div>
    <div class="navbar-end">
        @if (session()->has('api_token'))
        <div class="flex items-center gap-2">
            <p class="text-md font-semibold">{{ session('user_data')['staff']['nama'] }}</p>
            <form action="{{ route('logout') }}" method="post">
                @csrf
                <button class="btn bg-red-400 text-red-900 px-2 py-1 rounded shadow-md transition-all duration-200 transform-gpu hover:bg-red-700 hover:shadow-red-400/50 hover:-translate-y-px hover:text-red-300">Logout</button>
            </form>
        </div>
        @else
            <a href="{{ route('login') }}"
                class="px-2 py-1 bg-green-500/70 font-semibold text-green-900 rounded-lg shadow-md hover:-translate-y-px hover:shadow-md hover:shadow-green-500/50 transition-all duration-200">Login</a>
        @endif
    </div>
</div>
