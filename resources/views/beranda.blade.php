@extends('layouts.index')

@section('title', 'KlinikR1')
@section('content')
    <section class="bg-linear-to-b from-brand-tertiary to-[#2C3753] pt-16 pb-24 px-4 sm:px-6 lg:px-8 text-white py-16 md:py-24">
    <div class="max-w-7xl mx-auto flex flex-col lg:flex-row items-center justify-between gap-12">

        <div class="lg:w-1/2">
            <p class="text-custom-green font-semibold mb-2">
                <span class="border-b-2 border-custom-green pb-1">Mitra kesehatan terpercaya Anda</span>
            </p>
            <h1 class="text-5xl md:text-6xl font-extrabold leading-tight mt-4 mb-6">
                Layanan Medis <br>Berkualitas Tinggi <br>Untuk Keluarga
            </h1>
            <p class="text-gray-300 text-lg max-w-lg mb-8">
                Kami mengutamakan kesejahteraan Anda dengan menggabungkan teknologi untuk memberikan pengalaman berobat yang cepat, akurat, dan nyaman.
            </p>
            <div class="flex space-x-4">
                <a href="#" class="bg-custom-green text-custom-dark font-bold py-3 px-6 rounded-lg shadow-lg hover:bg-opacity-90 transition transform hover:-translate-y-0.5">
                    Buat Janji temu
                </a>
                <a href="#" class="border border-white text-white font-bold py-3 px-6 rounded-lg hover:bg-white hover:text-custom-dark transition">
                    Lihat layanan
                </a>
            </div>
        </div>

        <div class="lg:w-1/2 relative flex justify-center lg:justify-end">
            <div class="w-full max-w-md h-96 relative rounded-2xl overflow-hidden shadow-2xl">
                <img src="{{ asset('images/avatar-1.jpg') }}" alt="Ilustrasi Pasien" class="w-full h-full object-cover">

                <div class="absolute bottom-4 left-4 bg-white/90 backdrop-blur-sm p-3 rounded-xl shadow-lg flex items-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span class="text-sm font-semibold text-gray-800">Sertifikasi 100% MyKlinik</span>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="max-w-7xl mx-auto px-4 -mt-16 lg:-mt-20 relative z-10 grid grid-cols-1 md:grid-cols-2 gap-6">

    <div class="bg-white p-6 rounded-xl shadow-xl border-l-4 border-custom-teal flex justify-between items-start transition hover:shadow-2xl hover:scale-[1.01]">
        <div>
            <h3 class="text-xl font-bold text-gray-800 mb-1">Jadwal Dokter</h3>
            <p class="text-gray-500 text-sm mb-4">Temukan dokter umum & spesialis kami yang siap melayani.</p>
            <a href="#" class="text-custom-green font-semibold text-sm flex items-center hover:underline">
                Lihat Jadwal
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>
        <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center text-gray-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-xl border-l-4 border-custom-light-teal flex justify-between items-start transition hover:shadow-2xl hover:scale-[1.01]">
        <div>
            <h3 class="text-xl font-bold text-gray-800 mb-1">Pasien Baru?</h3>
            <p class="text-gray-500 text-sm mb-4">Daftar akun baru untuk mengaktifkan layanan jangka panjang.</p>
            <a href="/register" class="text-custom-green font-semibold text-sm flex items-center hover:underline">
                Daftar Sekarang
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>
        <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center text-gray-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
            </svg>
        </div>
    </div>
</div>

<div class="mb-20"></div>

---

<section class="max-w-7xl mx-auto px-4 py-8">
    <h2 class="text-3xl font-extrabold text-center text-gray-800 mb-2">KLINIK YANG TERSEDIA</h2>
    <p class="text-gray-500 text-center text-xl mb-12">Beberapa Klinik yang Tersedia</p>

    <div class="grid grid-cols-2 md:grid-cols-5 gap-6">

        @php
            $kliniks = [
                ['nama' => 'Umum', 'img' => 'images/klinik-1.jpg'],
                ['nama' => 'Gigi', 'img' => 'images/klinik-2.jpg'],
                ['nama' => 'Mata', 'img' => 'images/klinik-3.jpg'],
                ['nama' => 'Kulit & Kelamin', 'img' => 'images/klinik-4.jpg'],
                ['nama' => 'Gizi', 'img' => 'images/klinik-5.jpg'],
            ];
        @endphp

        @foreach ($kliniks as $klinik)
        <div class="flex flex-col items-center text-center group">
            <div class="relative w-full aspect-[4/3] rounded-xl overflow-hidden shadow-lg mb-3 transition transform group-hover:scale-105">
                <img src="{{ asset($klinik['img']) }}" alt="Klinik {{ $klinik['nama'] }}" class="w-full h-full object-cover">

                <div class="absolute inset-0 border-2 border-transparent group-hover:border-custom-green rounded-xl transition duration-300"></div>
            </div>
            <h4 class="text-sm text-gray-500">Klinik</h4>
            <h3 class="text-lg font-bold text-gray-800 group-hover:text-custom-green transition">{{ $klinik['nama'] }}</h3>
        </div>
        @endforeach

    </div>
</section>

---

<section class="max-w-7xl mx-auto px-4 py-20 bg-gray-50">
    <h2 class="text-3xl font-extrabold text-center text-gray-800 mb-2">LAYANAN KAMI</h2>
    <p class="text-gray-500 text-center text-xl mb-12">Solusi Kesehatan Terintegrasi</p>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

        <div class="bg-white p-8 rounded-xl shadow-md border-t-4 border-gray-200 hover:shadow-lg transition">
            <div class="w-12 h-12 bg-custom-green/10 rounded-full flex items-center justify-center mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-custom-green" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Pemeriksaan Umum</h3>
            <p class="text-gray-600 text-sm">Konsultasi dan pemeriksaan kesehatan umum dengan dokter profesional setiap waktu.</p>
        </div>

        <div class="bg-white p-8 rounded-xl shadow-md border-t-4 border-gray-200 hover:shadow-lg transition">
            <div class="w-12 h-12 bg-custom-green/10 rounded-full flex items-center justify-center mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-custom-green" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2-12H7a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2V6a2 2 0 00-2-2z" />
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Formasi & E-Resep</h3>
            <p class="text-gray-600 text-sm">Pesan obat dan tebus resep secara online tanpa perlu ke apotek.</p>
        </div>

        <div class="bg-white p-8 rounded-xl shadow-md border-t-4 border-gray-200 hover:shadow-lg transition">
            <div class="w-12 h-12 bg-custom-green/10 rounded-full flex items-center justify-center mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-custom-green" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2.5m-10 4h10m-10 0a2 2 0 01-2-2v-2m14 2a2 2 0 002-2v-2" />
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Rujukan Digital</h3>
            <p class="text-gray-600 text-sm">Proses rujukan ke spesialis atau rumah sakit mitra jadi lebih mudah dan cepat.</p>
        </div>
    </div>
</section>
@endsection
