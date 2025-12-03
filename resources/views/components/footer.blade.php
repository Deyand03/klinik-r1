<footer class="relative bg-brand-dark text-white overflow-hidden">
    <ul class="circles">
        <li class="left-[15%]" style="width: 120px; height: 120px; animation-delay: 0s; animation-duration: 25s;">
        </li>

        <li class="left-[5%]" style="width: 20px; height: 20px; animation-delay: 2s; animation-duration: 10s;">
        </li>

        <li class="left-[70%]" style="width: 60px; height: 60px; animation-delay: 4s; animation-duration: 18s;">
        </li>

        <li class="left-[40%]" style="width: 15px; height: 15px; animation-delay: 0s; animation-duration: 12s;">
        </li>

        <li class="left-[65%]" style="width: 150px; height: 150px; animation-delay: 7s; animation-duration: 30s;">
        </li>

        <li class="left-[85%]" style="width: 80px; height: 80px; animation-delay: 3s; animation-duration: 22s;">
        </li>

        <li class="left-[35%]" style="width: 30px; height: 30px; animation-delay: 9s; animation-duration: 11s;">
        </li>

        <li class="left-[50%]" style="width: 25px; height: 25px; animation-delay: 15s; animation-duration: 45s;">
        </li>

        <li class="left-[20%]" style="width: 15px; height: 15px; animation-delay: 2s; animation-duration: 35s;">
        </li>

        <li class="left-[90%]" style="width: 50px; height: 50px; animation-delay: 11s; animation-duration: 19s;">
        </li>

        <li class="left-[10%]"
            style="width: 200px; height: 200px; animation-delay: 5s; animation-duration: 40s; background: rgba(255,255,255,0.05);">
        </li>
    </ul>

    <div class="relative z-10 max-w-7xl mx-auto px-6 py-12 lg:py-16">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">

            <div class="col-span-1 md:col-span-2">
                <a href="/" class="text-3xl font-bold text-brand-primary mb-4 block">
                    🏥 SI-Klinik
                </a>
                <p class="text-gray-300 max-w-sm leading-relaxed">
                    Mitra kesehatan terpercaya keluarga Anda dengan layanan terintegrasi dan dokter profesional. Satu
                    akun untuk semua kebutuhan medis.
                </p>
            </div>
            <div>
                <h3 class="text-lg font-bold text-brand-secondary mb-4 uppercase tracking-wider">SI Klinik</h3>
                <ul class="space-y-3">
                    <li><a href="/"
                            class="text-gray-300 hover:text-white hover:translate-x-2 transition inline-block">Beranda</a>
                    </li>
                    <li><a href="{{ route('cari_dokter') }}"
                            class="text-gray-300 hover:text-white hover:translate-x-2 transition inline-block">Jadwal
                            Dokter</a></li>
                    <li><a href="{{ route('login') }}"
                            class="text-gray-300 hover:text-white hover:translate-x-2 transition inline-block">Masuk
                            Akun</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-lg font-bold text-brand-secondary mb-4 uppercase tracking-wider">Hubungi Kami</h3>
                <ul class="space-y-3 text-gray-300">
                    <li class="flex items-start gap-3">
                        <span>📍</span>
                        <span>Mendalo<br>Jambi, Indonesia</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <span>📧</span>
                        <span>portalmyklinik.vercel.app</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="border-t border-white/10 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-gray-400 text-sm">
                &copy; {{ date('Y') }} Klinik Umum Sehat. All rights reserved.
            </p>
            <div class="flex space-x-6">
                <a href="#" class="text-gray-400 hover:text-brand-primary transition">Kebijakan Privasi</a>
                <a href="#" class="text-gray-400 hover:text-brand-primary transition">Syarat & Ketentuan</a>
            </div>
        </div>
    </div>
</footer>
