@extends('layouts.index')

@section('title', 'Klinik Gigi - KlinikR1')

@section('content')
    <div class="bg-white min-h-screen font-sans pt-18">

        <div class="bg-[#6379AA] md:p-4 mb-12">
            <div class="grid grid-cols-3 gap-2 md:h-64 lg:h-80 w-80%">
                {{-- Gambar 1 --}}
                <div
                    class="relative w-full h-full rounded-2xl overflow-hidden bg-gray-200 flex items-center justify-center group">
                    <span class="text-gray-500 text-sm md:text-base font-medium text-center px-2 absolute z-0">Gambar tidak
                        tersedia</span>
                    <img src="{{ asset('img/foto1.jpg') }}" alt="Tensi"
                        class="w-full h-full object-cover z-10 relative rounded-2xl" onerror="this.style.display='none'">
                </div>
                {{-- Gambar 2 --}}
                <div
                    class="relative w-full h-full rounded-2xl overflow-hidden bg-gray-200 flex items-center justify-center group">
                    <span class="text-gray-500 text-sm md:text-base font-medium text-center px-2 absolute z-0">Gambar tidak
                        tersedia</span>
                    <img src="{{ asset('img/foto2.jpg') }}" alt="Mata"
                        class="w-full h-full object-cover z-10 relative rounded-2xl" onerror="this.style.display='none'">
                </div>
                {{-- Gambar 3 --}}
                <div
                    class="relative w-full h-full rounded-2xl overflow-hidden bg-gray-200 flex items-center justify-center group">
                    <span class="text-gray-500 text-sm md:text-base font-medium text-center px-2 absolute z-0">Gambar tidak
                        tersedia</span>
                    <img src="{{ asset('img/foto3.jpg') }}" alt="Gigi"
                        class="w-full h-full object-cover z-10 relative rounded-2xl" onerror="this.style.display='none'">
                </div>
            </div>
        </div>

        {{-- SECTION 2: KONTEN UTAMA (Sidebar & Penjelasan) --}}
        <div class="container mx-auto px-4 md:px-12 max-w-7xl lg:px-8 mb-20">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">

                {{-- SIDEBAR MENU (Kiri) - Mengambil 3 Kolom --}}
                <div class="lg:col-span-3">
                    <h3 class="text-[#2B3A55] font-bold text-xl mb-4 uppercase tracking-wide">Klinik</h3>

                    <div class="flex flex-col border-t border-gray-200">

                        {{-- MENU ITEM: UMUM (Inactive) --}}
                        <a href="{{ route('fasilitas-layanan.klinik-umum') }}"
                            class="group flex justify-between items-center py-4 px-2 border-b border-gray-200 hover:text-[#7DD3D5] transition-colors">
                            <span class="text-[#2B3A55] font-bold text-lg group-hover:pl-1 transition-all">Umum</span>
                        </a>

                        {{-- MENU ITEM: GIGI (ACTIVE STATE) --}}
                        {{-- Perhatikan class: bg-gray-50, border-l-[6px], border-[#7DD3D5] --}}
                        <a href="{{ route('fasilitas-layanan.klinik-gigi') }}"
                            class="group flex justify-between items-center py-4 px-2 border-b border-gray-200 hover:text-[#7DD3D5] transition-colors">
                            <span class="text-[#2B3A55] font-bold text-lg group-hover:pl-1 transition-all">Gigi</span>
                        </a>

                        {{-- MENU ITEM: MATA (Inactive) --}}
                        <a href="{{ route('fasilitas-layanan.klinik-mata') }}"
                            class="group flex justify-between items-center py-4 px-2 border-b border-gray-200 hover:text-[#7DD3D5] transition-colors">
                            <span class="text-[#2B3A55] font-bold text-lg group-hover:pl-1 transition-all">Mata</span>
                        </a>

                        {{-- MENU ITEM: GIZI (Inactive) --}}
                        <a href="{{ route('fasilitas-layanan.klinik-gizi') }}"
                            class="flex justify-between items-center py-4 px-4 bg-gray-50 border-b border-l-[6px] border-[#7DD3D5] shadow-sm">
                            <span class="text-[#2B3A55] font-bold text-lg">Gizi</span>
                            {{-- Icon Segitiga Khas Active State --}}
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="w-4 h-4 text-[#7DD3D5]">
                                <path
                                    d="M4.5 3.75a3 3 0 00-3 3v10.5a3 3 0 003 3h15a3 3 0 003-3V6.75a3 3 0 00-3-3h-15zm4.125 3a.75.75 0 101.5 0 .75.75 0 00-1.5 0zm0 3.75a.75.75 0 101.5 0 .75.75 0 00-1.5 0zm0 3.75a.75.75 0 101.5 0 .75.75 0 00-1.5 0z"
                                    fill-opacity="0" />
                                <path fill-rule="evenodd"
                                    d="M4.5 5.653c0-1.426 1.529-2.33 2.779-1.643l11.54 6.348c1.295.712 1.295 2.573 0 3.285L7.28 19.991c-1.25.687-2.779-.217-2.779-1.643V5.653z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>

                        {{-- MENU ITEM: KULIT (Inactive) --}}
                        <a href="{{ route('fasilitas-layanan.klinik-kulit') }}"
                            class="group flex justify-between items-center py-4 px-2 border-b border-gray-200 hover:text-[#7DD3D5] transition-colors">
                            <span class="text-[#2B3A55] font-bold text-lg group-hover:pl-1 transition-all">Kulit dan
                                Kelamin</span>
                        </a>

                    </div>
                </div>

                <div class="lg:col-span-9 pl-0 lg:pl-8">
                    <h1 class="text-[#2B3A55] font-bold text-3xl md:text-4xl mb-6">Gizi</h1>

                    <div class="text-gray-500 text-base leading-relaxed space-y-4 mb-10 text-justify">
                        <p>
                            Layanan konsultasi dan pengaturan gizi secara komprehensif untuk membantu Anda mengatasi
                            berbagai masalah nutrisi dan mendukung pola hidup sehat, ditangani oleh ahli gizi profesional
                            sesuai kebutuhan spesifik Anda.
                        </p>
                        <p>
                            Klinik gizi kami menyediakan asesmen nutrisi, perencanaan diet, serta pendampingan berkelanjutan
                            dengan standar pelayanan yang aman dan terukur untuk memastikan perubahan kesehatan Anda
                            berlangsung optimal dan berkelanjutan.
                        </p>
                    </div>

                    <h2 class="text-[#2B3A55] font-bold text-2xl mb-4">Layanan</h2>

                    <ul class="space-y-3 text-gray-500">
                        <li class="flex items-start">
                            <span class="mr-2 text-[#7DD3D5] font-bold text-xl">•</span>
                            <span>Konsultasi Dokter</span>
                        </li>
                        <li class="flex items-start">
                            <span class="mr-2 text-[#7DD3D5] font-bold text-xl">•</span>
                            <span>Pemeriksaan Fisik</span>
                        </li>
                        <li class="flex items-start">
                            <span class="mr-2 text-[#7DD3D5] font-bold text-xl">•</span>
                            <span>Review Status Gizi</span>
                        </li>
                        <li class="flex items-start">
                            <span class="mr-2 text-[#7DD3D5] font-bold text-xl">•</span>
                            <span>Edukasi Gizi</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- CARI DOKTER --}}
        <div class="bg-gray-50 py-8">
            <div class="container mx-auto px-4 md:px-12 lg:px-24">
                <div class="flex flex-col md:flex-row items-center gap-10">
                    <div class="w-1 md:w-1/2 flex justify-center">
                        <img src="{{ asset('img/caridokter.png') }}" alt="Tim Dokter"
                            class="w-full max-w-md object-contain mix-blend-multiply">
                    </div>

                    <div class="w-full md:w-1/2 text-left">
                        <h2 class="text-[#7DD3D5] font-bold text-3xl mb-4">CARI DOKTER</h2>
                        <p class="text-[#6379AA] font-semibold mb-2 text-lg">
                            Temukan Dokter dan Informasi Jadwal Praktek di sini
                        </p>
                        <p class="text-gray-500 mb-6 text-sm">
                            Cari spesialisasi yang Anda butuhkan dan buat janji temu dengan mudah.
                        </p>

                        <a href="{{ route('cari_dokter') }}"
                            class="btn border-none bg-[#7DD3D5] hover:bg-teal-500 text-[#0d0d1e] font-bold px-8 rounded-md shadow-lg">
                            Cari Dokter
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @vite('resources/js/utility/navbar_beranda.js')
@endsection
