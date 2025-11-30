@extends('layouts.index')

@section('title', 'KlinikR1')
@section('content')
    <section class="relative bg-linear-to-br from-brand-tertiary to-brand-dark text-white pt-24 pb-48 overflow-hidden">
        <div
            class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 bg-brand-btn rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob">
        </div>
        <div
            class="absolute top-0 left-0 -ml-20 -mt-20 w-72 h-72 bg-brand-primary rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-blob animation-delay-2000">
        </div>

        <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">

                <div class="space-y-6" data-aos="fade-right" data-aos-duration="1000">
                    <span
                        class="inline-block py-1 px-3 rounded-full bg-brand-primary/20 text-brand-primary text-sm font-semibold tracking-wide border border-brand-primary/30">
                        ✨ Mitra Kesehatan Terpercaya Anda
                    </span>
                    <h1 class="text-4xl lg:text-6xl font-extrabold leading-tight">
                        Layanan Medis <br>
                        <span class="text-transparent bg-clip-text bg-linear-to-r from-brand-primary to-brand-secondary">
                            Berkualitas Tinggi
                        </span>
                        Untuk Keluarga
                    </h1>
                    <p class="text-lg text-gray-300 max-w-lg">
                        Kami menggabungkan keahlian medis dengan teknologi sistem terintegrasi untuk memberikan pengalaman
                        berobat yang cepat, akurat, dan nyaman.
                    </p>

                    <div class="flex flex-wrap gap-4 pt-4">
                        <a href="/doctors"
                            class="btn bg-brand-btn hover:bg-brand-btn/90 text-white border-none px-8 rounded-full shadow-lg shadow-brand-btn/30 transition-transform hover:-translate-y-1">
                            Buat Janji Temu
                        </a>
                        <a href="#layanan"
                            class="btn btn-outline text-brand-primary hover:bg-brand-primary hover:text-brand-dark border-brand-primary rounded-full px-8">
                            Lihat Layanan
                        </a>
                    </div>
                </div>

                <div class="relative lg:h-full flex justify-center lg:justify-end">
                    <div class="relative w-full max-w-md lg:max-w-lg">
                        <div
                            class="absolute top-0 -left-4 w-72 h-72 bg-brand-secondary rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob">
                        </div>
                        <img src="https://images.unsplash.com/photo-1579684385127-1ef15d508118?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                            alt="Dokter"
                            class="relative rounded-2xl shadow-2xl border-4 border-white/10 transform hover:scale-105 transition duration-500 ease-in-out object-cover h-[500px] w-full">
                        <div
                            class="absolute bottom-10 -left-10 bg-white p-4 rounded-xl shadow-xl flex items-center gap-4 animate-bounce duration-3000ms">
                            <div class="bg-green-100 p-3 rounded-full text-green-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Kualitas Pelayanan</p>
                                <p class="font-bold text-gray-800">100% Terakreditasi</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<div class="max-w-7xl mx-auto px-4 -mt-16 lg:-mt-20 relative z-10 grid grid-cols-1 md:grid-cols-2 gap-6">

    <div
                class="bg-white p-8 rounded-3xl shadow-xl border-l-8 border-brand-secondary group hover:-translate-y-2 transition duration-300">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-2xl font-bold text-brand-dark mb-2 group-hover:text-brand-btn transition">Jadwal
                            Dokter</h3>
                        <p class="text-gray-600 mb-6">Cek ketersediaan dokter umum spesialis kami hari ini.</p>
                        <a href="/doctors"
                            class="text-brand-btn font-semibold flex items-center gap-2 group-hover:gap-4 transition-all">
                            Lihat Jadwal <span class="text-xl">→</span>
                        </a>
                    </div>
                    <div class="p-4 bg-brand-secondary/10 rounded-2xl text-brand-secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div
                class="bg-white p-8 rounded-3xl shadow-xl border-l-8 border-brand-primary group hover:-translate-y-2 transition duration-300">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-2xl font-bold text-brand-dark mb-2 group-hover:text-brand-secondary transition">
                            Pasien Baru?</h3>
                        <p class="text-gray-600 mb-4">Daftar online sekarang untuk menghindari antrian panjang.</p>
                        <a href="/register"
                            class="text-brand-secondary font-semibold flex items-center gap-2 group-hover:gap-4 transition-all">
                            Daftar Sekarang <span class="text-xl">→</span>
                        </a>
                    </div>
                    <div class="p-4 bg-brand-primary/10 rounded-2xl text-brand-secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                    </div>
                </div>
            </div>
</div>

<div class="mb-20"></div>



<section class="max-w-7xl mx-auto px-4 py-20">
    <div class="text-center mb-16">
        <h2 class="text-brand-secondary font-bold tracking-wider uppercase mb-2">KLINIK YANG TERSEDIA</h2>
        <p class="text-3xl md:text-4xl font-bold text-brand-dark">Beberapa Klinik yang Tersedia</p>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-3 gap-8">

        @php
            $kliniks = [
                ['nama' => 'Umum', 'img' => 'images/dokterumum.jpg'],
                ['nama' => 'Gigi', 'img' => 'images/doktergigi.jpg'],
                ['nama' => 'Mata', 'img' => 'images/doktermata.jpg'],
                ['nama' => 'Kulit & Kelamin', 'img' => 'images/dokterkulitkelamin.jpg'],
                ['nama' => 'Gizi', 'img' => 'images/doktergizi.jpg'],
            ];
        @endphp

        @foreach ($kliniks as $klinik)
        <div class="bg-white rounded-xl shadow-lg border-r-8 border-brand-secondary overflow-hidden group transition duration-300 hover:shadow-xl">

            <div class="flex items-center w-full">

                <div class="w-1/2 aspect-4/3 shrink-0">
                    <img src="{{ asset($klinik['img']) }}" alt="Klinik {{ $klinik['nama'] }}" class="w-full h-full object-cover">
                </div>

                <div class="w-1/2 flex items-center h-full">

                    <div class="border-l-4 border-custom-green h-full shrink-0"></div>

                    <div class="p-3">
                        <h4 class="text-sm text-gray-500 font-semibold mb-0.5">Klinik</h4>
                        <h3 class="text-lg font-bold text-blue-600 group-hover:text-custom-green transition">{{ $klinik['nama'] }}</h3>
                    </div>
                </div>
            </div>

            <div class="absolute inset-0 border-2 border-transparent rounded-xl pointer-events-none"></div>

        </div>
        @endforeach

    </div>
</section>



<section id="layanan" class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-brand-secondary font-bold tracking-wider uppercase mb-2">Layanan Kami</h2>
                <h3 class="text-3xl md:text-4xl font-bold text-brand-dark">Solusi Kesehatan Terintegrasi</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div
                    class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-xl hover:bg-brand-dark hover:text-white transition duration-300 group cursor-pointer">
                    <div
                        class="w-14 h-14 bg-brand-tertiary/20 text-brand-tertiary group-hover:bg-white/20 group-hover:text-brand-primary rounded-xl flex items-center justify-center mb-6 transition">
                        <span class="text-3xl">🩺</span>
                    </div>
                    <h4 class="text-xl font-bold mb-3">Pemeriksaan Umum</h4>
                    <p class="text-gray-500 group-hover:text-gray-300">Konsultasi dokter umum dengan rekam medis digital
                        yang terintegrasi.</p>
                </div>

                <div
                    class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-xl hover:bg-brand-dark hover:text-white transition duration-300 group cursor-pointer">
                    <div
                        class="w-14 h-14 bg-brand-secondary/20 text-brand-secondary group-hover:bg-white/20 group-hover:text-brand-primary rounded-xl flex items-center justify-center mb-6 transition">
                        <span class="text-3xl">💊</span>
                    </div>
                    <h4 class="text-xl font-bold mb-3">Farmasi & E-Resep</h4>
                    <p class="text-gray-500 group-hover:text-gray-300">Penebusan obat langsung dari resep digital tanpa
                        antri lama.</p>
                </div>

                <div
                    class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-xl hover:bg-brand-dark hover:text-white transition duration-300 group cursor-pointer">
                    <div
                        class="w-14 h-14 bg-brand-btn/20 text-brand-btn group-hover:bg-white/20 group-hover:text-brand-primary rounded-xl flex items-center justify-center mb-6 transition">
                        <span class="text-3xl">📄</span>
                    </div>
                    <h4 class="text-xl font-bold mb-3">Rujukan Digital</h4>
                    <p class="text-gray-500 group-hover:text-gray-300">Proses rujukan ke RS lebih mudah dengan surat digital
                        standar.</p>
                </div>
            </div>
        </div>
    </section>
@endsection
