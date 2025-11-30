@extends('layouts.index')

@section('title', 'KlinikR1')

@section('content')
    <div class="bg-white min-h-screen pt-18">

        <div class="bg-[#6379AA] md:p-4 mb-8">
            <div class="grid grid-cols-3 gap-2 md:h-64 lg:h-80 w-80%">
                <div
                    class="relative w-full h-full rounded-2xl overflow-hidden bg-gray-200 flex items-center justify-center group">
                    <span class="text-gray-500 text-sm md:text-base font-medium text-center px-2 absolute z-0">
                        Gambar tidak tersedia
                    </span>
                    <img src="{{ asset('img/foto1.jpg') }}" alt="Tensi"
                        class="w-full h-full object-cover z-10 relative rounded-2xl" onerror="this.style.display='none'">
                </div>
                <div
                    class="relative w-full h-full rounded-2xl overflow-hidden bg-gray-200 flex items-center justify-center group">
                    <span class="text-gray-500 text-sm md:text-base font-medium text-center px-2 absolute z-0">
                        Gambar tidak tersedia
                    </span>
                    <img src="{{ asset('img/foto2.jpg') }}" alt="Mata"
                        class="w-full h-full object-cover z-10 relative rounded-2xl" onerror="this.style.display='none'">
                </div>

                <div
                    class="relative w-full h-full rounded-2xl overflow-hidden bg-gray-200 flex items-center justify-center group">
                    <span class="text-gray-500 text-sm md:text-base font-medium text-center px-2 absolute z-0">
                        Gambar tidak tersedia
                    </span>
                    <img src="{{ asset('img/foto3.jpg') }}" alt="Gigi"
                        class="w-full h-full object-cover z-10 relative rounded-2xl" onerror="this.style.display='none'">
                </div>
            </div>
        </div>

        <div class="container mx-auto px-4 md:px-12 lg:px-24">

            <div class="mb-16">
                <div class="text-center mb-12">
                    {{-- Menggunakan warna hijau header sesuai gambar (#77C49F) --}}
                    <h2 class="text-[#77C49F] font-bold text-3xl md:text-4xl uppercase mb-3">
                        Layanan Kami
                    </h2>
                    <p class="text-[#6379AA] font-medium text-base md:text-lg">
                        Temukan ragam Layanan Kesehatan Unggulan yang bermutu tinggi
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-10">

                    {{-- Card 1: Ambulans --}}
                    {{-- h-52: Membuat card lebih tinggi --}}
                    {{-- border-r-[8px]: Membuat garis tebal di sebelah KANAN --}}
                    <div class="flex bg-white shadow-lg rounded-xl overflow-hidden h-52 border-r-[8px] border-[#4EC3C7]">
                        {{-- Gambar: Lebar 40% (w-2/5) --}}
                        <figure class="w-2/5 relative h-full">
                            <img src="{{ asset('img/foto4.jpg') }}"
                                class="absolute inset-0 w-full h-full object-cover" alt="Ambulans" />
                        </figure>

                        {{-- Konten: Lebar 60% (w-3/5) --}}
                        <div class="w-3/5 flex flex-col justify-center p-6 bg-gray-50/30">
                            <h3 class="text-[#2B3A55] font-bold text-xl mb-2">Ambulans</h3>
                            <p class="text-sm text-gray-500 leading-relaxed">
                                Layanan Ambulans yang siaga 24 jam di nomor darurat (0123) 4567 8910
                            </p>
                        </div>
                    </div>

                    {{-- Card 2: Pemeriksaan Mata --}}
                    <div class="flex bg-white shadow-lg rounded-xl overflow-hidden h-52 border-r-[8px] border-[#4EC3C7]">
                        <figure class="w-2/5 relative h-full">
                            <img src="{{ asset('img/foto5.jpg') }}"
                                class="absolute inset-0 w-full h-full object-cover" alt="Mata" />
                        </figure>
                        <div class="w-3/5 flex flex-col justify-center p-6 bg-gray-50/30">
                            <h3 class="text-[#2B3A55] font-bold text-xl mb-2">Pemeriksaan Mata</h3>
                            <p class="text-sm text-gray-500 leading-relaxed">
                                Ragam layanan pemeriksaan dan deteksi gangguan mata dengan peralatan diagnostik terkini
                            </p>
                        </div>
                    </div>

                    {{-- Card 3: Pemeriksaan Gigi --}}
                    <div class="flex bg-white shadow-lg rounded-xl overflow-hidden h-52 border-r-[8px] border-[#4EC3C7]">
                        <figure class="w-2/5 relative h-full">
                            <img src="{{ asset('img/foto6.jpg') }}"
                                class="absolute inset-0 w-full h-full object-cover" alt="Gigi" />
                        </figure>
                        <div class="w-3/5 flex flex-col justify-center p-6 bg-gray-50/30">
                            <h3 class="text-[#2B3A55] font-bold text-xl mb-2">Pemeriksaan Gigi</h3>
                            <p class="text-sm text-gray-500 leading-relaxed">
                                Layanan pemeriksaan komprehensif untuk mendeteksi dini masalah gigi dan mulut
                            </p>
                        </div>
                    </div>

                    {{-- Card 4: Mikrodermabrasi --}}
                    <div class="flex bg-white shadow-lg rounded-xl overflow-hidden h-52 border-r-[8px] border-[#4EC3C7]">
                        <figure class="w-2/5 relative h-full">
                            <img src="{{ asset('img/foto7.jpg') }}"
                                class="absolute inset-0 w-full h-full object-cover" alt="Mikrodermabrasi" />
                        </figure>
                        <div class="w-3/5 flex flex-col justify-center p-6 bg-gray-50/30">
                            <h3 class="text-[#2B3A55] font-bold text-xl mb-2">Mikrodermabrasi</h3>
                            <p class="text-sm text-gray-500 leading-relaxed">
                                Layanan peremajaan kulit non-invasif yang mampu menyamarkan noda serta garis halus pada
                                wajah
                            </p>
                        </div>
                    </div>

                </div>
            </div>
            <div class="mb-16">
                <div class="text-center mb-12">
                    {{-- Menggunakan warna hijau header sesuai gambar (#77C49F) --}}
                    <h2 class="text-[#77C49F] font-bold text-3xl md:text-4xl uppercase mb-3">
                        Fasilitas Kami
                    </h2>
                    <p class="text-[#6379AA] font-medium text-base md:text-lg">
                        Telusuri ragam Fasilitas Kesehatan modern, terlengkap, dan terintegrasi
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-10">

                    {{-- Card 1: Ambulans --}}
                    {{-- h-52: Membuat card lebih tinggi --}}
                    {{-- border-r-[8px]: Membuat garis tebal di sebelah KANAN --}}
                    <div class="flex bg-white shadow-lg rounded-xl overflow-hidden h-52 border-r-[8px] border-[#4EC3C7]">
                        {{-- Gambar: Lebar 40% (w-2/5) --}}
                        <figure class="w-2/5 relative h-full">
                            <img src="{{ asset('img/foto8.jpg') }}"
                                class="absolute inset-0 w-full h-full object-cover" alt="Ambulans" />
                        </figure>

                        {{-- Konten: Lebar 60% (w-3/5) --}}
                        <div class="w-3/5 flex flex-col justify-center p-6 bg-gray-50/30">
                            <h3 class="text-[#2B3A55] font-bold text-xl mb-2">Ruang Tunggu Nyaman</h3>
                            <p class="text-sm text-gray-500 leading-relaxed">
                                Nikmati ruang tunggu kami yang luas, bersih,
                                dan menyenangkan.
                            </p>
                        </div>
                    </div>

                    <div class="flex bg-white shadow-lg rounded-xl overflow-hidden h-52 border-r-[8px] border-[#4EC3C7]">
                        <figure class="w-2/5 relative h-full">
                            <img src="{{ asset('img/foto9.jpg') }}"
                                class="absolute inset-0 w-full h-full object-cover" alt="Mata" />
                        </figure>
                        <div class="w-3/5 flex flex-col justify-center p-6 bg-gray-50/30">
                            <h3 class="text-[#2B3A55] font-bold text-xl mb-2">Laboratorium</h3>
                            <p class="text-sm text-gray-500 leading-relaxed">
                                Menyediakan pemeriksaan dasar secara cepat dan
                                akurat untuk mendukung diagnosis dokter.
                            </p>
                        </div>
                    </div>

                    {{-- Card 3: Pemeriksaan Gigi --}}
                    <div class="flex bg-white shadow-lg rounded-xl overflow-hidden h-52 border-r-[8px] border-[#4EC3C7]">
                        <figure class="w-2/5 relative h-full">
                            <img src="{{ asset('img/foto10.jpg') }}"
                                class="absolute inset-0 w-full h-full object-cover" alt="Gigi" />
                        </figure>
                        <div class="w-3/5 flex flex-col justify-center p-6 bg-gray-50/30">
                            <h3 class="text-[#2B3A55] font-bold text-xl mb-2">Ruang Tindakan</h3>
                            <p class="text-sm text-gray-500 leading-relaxed">
                                Dilengkapi peralatan medis standar untuk
                                menangani tindakan ringan.
                            </p>
                        </div>
                    </div>

                    {{-- Card 4: Mikrodermabrasi --}}
                    <div class="flex bg-white shadow-lg rounded-xl overflow-hidden h-52 border-r-[8px] border-[#4EC3C7]">
                        <figure class="w-2/5 relative h-full">
                            <img src="{{ asset('img/foto11.jpg') }}"
                                class="absolute inset-0 w-full h-full object-cover" alt="Mikrodermabrasi" />
                        </figure>
                        <div class="w-3/5 flex flex-col justify-center p-6 bg-gray-50/30">
                            <h3 class="text-[#2B3A55] font-bold text-xl mb-2">Farmasi</h3>
                            <p class="text-sm text-gray-500 leading-relaxed">
                                Menyediakan obat-obatan lengkap sesuai resep
                                dokter dengan pelayanan yang ramah dan cepat.
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- SECTION 4: KLINIK YANG KAMI MILIKI (Blue Section) --}}
        <div class="bg-[#6379AA] py-12">
            <div class="container mx-auto px-4 md:px-12 lg:px-24">
                <div class="text-center mb-8">
                    <h2
                        class="text-[#7DD3D5] font-extrabold text-2xl md:text-3xl uppercase tracking-wider mb-2 drop-shadow-sm">
                        KLINIK YANG KAMI MILIKI
                    </h2>
                    <p class="text-white/80 text-sm">Kenali klinik-klinik kami dan detail informasi layanannya</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {{-- Button Umum --}}
                    <a href="#"
                        class="bg-white rounded p-4 flex justify-between items-center hover:bg-gray-100 transition shadow-sm group">
                        <span class="text-[#6379AA] font-bold text-lg group-hover:pl-2 transition-all">Umum</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                            stroke="currentColor" class="w-6 h-6 text-[#7DD3D5]">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                    </a>

                    {{-- Button Gigi --}}
                    <a href="{{ route('fasilitas-layanan.klinik-gigi') }}"
                        class="bg-white rounded p-4 flex justify-between items-center hover:bg-gray-100 transition shadow-sm group">
                        <span class="text-[#6379AA] font-bold text-lg group-hover:pl-2 transition-all">Gigi</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                            stroke="currentColor" class="w-6 h-6 text-[#7DD3D5]">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                    </a>

                    {{-- Button Mata --}}
                    <a href="#"
                        class="bg-white rounded p-4 flex justify-between items-center hover:bg-gray-100 transition shadow-sm group">
                        <span class="text-[#6379AA] font-bold text-lg group-hover:pl-2 transition-all">Mata</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                            stroke="currentColor" class="w-6 h-6 text-[#7DD3D5]">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                    </a>

                    {{-- Button Gizi --}}
                    <a href="#"
                        class="bg-white rounded p-4 flex justify-between items-center hover:bg-gray-100 transition shadow-sm group">
                        <span class="text-[#6379AA] font-bold text-lg group-hover:pl-2 transition-all">Gizi</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                            stroke="currentColor" class="w-6 h-6 text-[#7DD3D5]">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                    </a>

                    {{-- Button Kulit --}}
                    <a href="#"
                        class="bg-white rounded p-4 flex justify-between items-center hover:bg-gray-100 transition shadow-sm group col-span-1 md:col-span-2 md:w-1/2 md:mx-auto">
                        <span class="text-[#6379AA] font-bold text-lg group-hover:pl-2 transition-all">Kulit &
                            Kelamin</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                            stroke="currentColor" class="w-6 h-6 text-[#7DD3D5]">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        {{-- SECTION 5: CARI DOKTER --}}
        <div class="bg-gray-50 py-8">
            <div class="container mx-auto px-4 md:px-12 lg:px-24">
                <div class="flex flex-col md:flex-row items-center gap-10">
                    <div class="w-full md:w-1/2 flex justify-center">
                        <img src="{{ asset('img/caridokter.png') }}"
                            alt="Tim Dokter" class="w-full max-w-md object-contain mix-blend-multiply">
                    </div>

                    <div class="w-full md:w-1/2 text-left">
                        <h2 class="text-[#7DD3D5] font-bold text-3xl mb-4">CARI DOKTER</h2>
                        <p class="text-[#6379AA] font-semibold mb-2 text-lg">
                            Temukan Dokter dan Informasi Jadwal Praktek di sini
                        </p>
                        <p class="text-gray-500 mb-6 text-sm">
                            Cari spesialisasi yang Anda butuhkan dan buat janji temu dengan mudah.
                        </p>

                        <button
                            class="btn border-none bg-[#7DD3D5] hover:bg-teal-500 text-[#0d0d1e] font-bold px-8 rounded-md shadow-lg">
                            Cari Dokter
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @vite('resources/js/utility/navbar_beranda.js')
@endsection
