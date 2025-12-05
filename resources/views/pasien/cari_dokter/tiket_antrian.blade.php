@extends('layouts.index')

@section('title', 'Tiket Antrian - KlinikR1')

@section('content')
    {{-- HEADER BACKGROUND --}}
    <div class="bg-linear-to-b from-brand-tertiary to-[#2C3753] pt-16 pb-32 px-4 sm:px-6 lg:px-8 relative">
        <div class="max-w-7xl mx-auto text-center">
            <h1 class="text-3xl md:text-4xl font-bold text-white mb-2">Booking Berhasil!</h1>
            <p class="text-gray-200">Silakan simpan tiket antrian di bawah ini.</p>
        </div>
    </div>

    {{-- KONTEN TIKET --}}
    <div class="bg-gray-50 pb-20 px-4">
        <div class="max-w-md mx-auto relative -mt-20 z-10">

            {{-- TIKET CARD --}}
            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100 relative">

                {{-- Hiasan Lingkaran "Sobekan Tiket" --}}
                <div class="absolute top-1/2 -left-3 w-6 h-6 bg-gray-50 rounded-full"></div>
                <div class="absolute top-1/2 -right-3 w-6 h-6 bg-gray-50 rounded-full"></div>

                {{-- Bagian Atas: Header Tiket --}}
                <div class="bg-brand-secondary p-6 text-center text-white relative overflow-hidden">
                    <div class="absolute top-0 right-0 -mr-4 -mt-4 w-20 h-20 bg-white/10 rounded-full blur-xl"></div>
                    <div class="absolute bottom-0 left-0 -ml-4 -mb-4 w-20 h-20 bg-white/10 rounded-full blur-xl"></div>

                    {{-- GANTI BAGIAN NOMOR ANTRIAN --}}
                    <h2 class="text-lg font-semibold tracking-widest uppercase opacity-90">Nomor Antrian</h2>
                    <div class="mt-2 text-6xl font-extrabold font-mono tracking-tighter">
                        {{ $tiket['no_antrian'] ?? 'A-???' }}
                    </div>

                    <p class="text-sm mt-2 font-medium bg-white/20 inline-block px-3 py-1 rounded-full">
                        Status: Menunggu Check-In
                    </p>
                </div>

                {{-- Garis Putus-putus --}}
                <div class="border-b-2 border-dashed border-gray-200 mx-6"></div>

                {{-- Bagian Bawah: Detail --}}
                <div class="p-8 space-y-6">

                    {{-- Info Pasien --}}
                    <div class="flex justify-between items-center pb-4 border-b border-gray-100">
                        <div>
                            <p class="text-xs text-gray-400 uppercase font-bold tracking-wider">Pasien</p>
                            <p class="text-brand-dark font-bold text-lg">Andi Pratama</p>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-gray-400 uppercase font-bold tracking-wider">Tanggal</p>
                            <p class="text-brand-dark font-bold text-lg">{{ date('d M Y') }}</p>
                        </div>
                    </div>

                    {{-- Info Dokter --}}
                    <div class="bg-gray-50 p-4 rounded-xl flex items-center gap-4">
                        <div class="avatar placeholder">
                            <div class="bg-brand-tertiary text-white rounded-full w-12">
                                <span class="text-lg font-bold">EA</span>
                            </div>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 font-bold uppercase">Dokter</p>
                            {{-- GANTI BAGIAN NAMA PASIEN & DOKTER --}}
                            <p class="text-brand-dark font-bold text-lg">{{ session('user_data')['name'] ?? 'Pasien' }}</p>
                            <p class="text-xs text-brand-secondary font-semibold">Klinik Gigi</p>
                        </div>
                    </div>

                    {{-- Instruksi --}}
                    <div class="bg-blue-50 p-4 rounded-xl border border-blue-100 flex gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600 shrink-0" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-xs text-blue-800 leading-relaxed">
                            Mohon tunjukkan layar ini kepada <b>Resepsionis</b> saat Anda tiba di klinik untuk validasi
                            antrian.
                        </p>
                    </div>

                </div>

                {{-- Action Buttons --}}
                <div class="p-6 bg-gray-50 border-t border-gray-100 flex flex-col gap-3">
                    <button onclick="window.print()"
                        class="btn btn-outline border-gray-300 text-gray-600 hover:bg-gray-100 hover:text-brand-dark w-full normal-case">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Simpan / Screenshot
                    </button>
                    <a href="{{ route('beranda') }}"
                        class="btn bg-brand-tertiary hover:bg-[#1a2336] text-white border-none w-full normal-case shadow-lg shadow-brand-tertiary/20">
                        Kembali ke Beranda
                    </a>
                </div>

            </div>
        </div>
    </div>

    @vite('resources/js/utility/navbar_beranda.js')
@endsection
