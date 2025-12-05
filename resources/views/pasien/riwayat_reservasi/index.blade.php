@extends('layouts.index')
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />


@section('title', 'KlinikR1')
@section('content')
    <section class="bg-gradient-to-r from-indigo-900 to-sky-700 text-white px-6 md:px-20 mb-4 pt-5 pb-15 relative">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-center">
            <div>
                <span class="bg-green-300 text-green-900 px-3 py-1 rounded-full text-sm font-semibold">
                    Mitra kesehatan terpercaya anda
                </span>

                <h1 class="text-4xl font-bold mt-4 leading-tight">
                    Catatan <br>
                    <span class="text-green-300">Kunjungan dan</span> <br>
                    Perawatan Anda
                </h1>

                <p class="mt-4 text-gray-100">
                    Semua catatan kunjungan, rekam medis, dan dokumen penting tersimpan aman. Cek kembali detail layanan
                    kesehatan Anda kapan pun dibutuhkan..
                </p>
            </div>

            <div class="flex justify-end">
                <img src="{{ asset('images/foto_riwayat_reservasi.png') }}" class="w-80 md:w-96"
                    alt="History Reservation Clinic">
            </div>
        </div>
    </section>

    <div class="max-xl -mt-14 z-20 relative mx-3">

        <div class="bg-white shadow-xl rounded-xl flex items-center justify-between py-6 px-10">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-2xl">
                    filter_alt
                </span>
                <span class="text-gray-700 font-medium">
                    Filter Berdasarkan Klinik
                </span>
            </div>
            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button class="bg-gray-100 text-gray-700 px-4 py-2 rounded flex items-center gap-2">

                        <span class="material-symbols-outlined">
                            arrow_drop_down
                        </span>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <x-dropdown-link href="#">Klinik A</x-dropdown-link>
                    <x-dropdown-link href="#">Klinik B</x-dropdown-link>
                    <x-dropdown-link href="#">Klinik C</x-dropdown-link>
                </x-slot>
            </x-dropdown>


        </div>
    </div>


    <!-- TABEL -->
    <div class="overflow-x-auto flex justify-center my-6 ">
        <!-- <table class="min-w-full bg-white border border-black rounded-lg overflow-hidden"> -->
        <table class="w-98/100 border border-black ">
            <thead class="bg-blue-400">
                <tr>
                    <th class="px-4 py-3 text-center font-bold text-gray-700 border border-black">Nama Dokter</th>
                    <th class="px-4 py-3 text-center font-bold text-gray-700 border border-black">Tanggal
                        Kunjungan</th>
                    <th class="px-4 py-3 text-center font-bold text-gray-700 border border-black">Rekam Medis</th>
                    <th class="px-4 py-3 text-center font-bold text-gray-700 border border-black">Status</th>
                    <th class="px-4 py-3 text-center font-bold text-gray-700 border border-black">Bukti Pembayaran
                    </th>
                    <th class="px-4 py-3 text-center font-bold text-gray-700 border border-black">Surat Rujukan
                    </th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td class="px-4 py-3 border border-black">dr. Benny Wijaya</td>
                    <td class="px-4 py-3 border border-black">12 Desember 2025</td>
                    <td class="px-4 py-3 border border-black">INV–1000</td>
                    <td class="px-4 py-3 border border-black">
                        <span
                            class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">Selesai</span>
                    </td>
                    <td class="px-4 py-3 border border-black text-blue-600 cursor-pointer">Lihat Nota</td>
                    <td class="px-4 py-3 border border-black">123123.pdf</td>
                </tr>

                <tr>
                    <td class="px-4 py-3 border border-black">drg. Deya Seprina</td>
                    <td class="px-4 py-3 border border-black">20 November 2025</td>
                    <td class="px-4 py-3 border border-black">INV–1001</td>
                    <td class="px-4 py-3 border border-black">
                        <span
                            class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">Selesai</span>
                    </td>
                    <td class="px-4 py-3 border border-black text-blue-600 cursor-pointer">Lihat Nota</td>
                    <td class="px-4 py-3 border border-black">234566.pdf</td>
                </tr>

                <tr>
                    <td class="px-4 py-3 border border-black">dr. Medina, Sp.M</td>
                    <td class="px-4 py-3 border border-black">30 Oktober 2025</td>
                    <td class="px-4 py-3 border border-black">INV–1002</td>
                    <td class="px-4 py-3 border border-black">
                        <span
                            class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">Selesai</span>
                    </td>
                    <td class="px-4 py-3 border border-black text-blue-600 cursor-pointer">Lihat Nota</td>
                    <td class="px-4 py-3 border border-black">987120.pdf</td>
                </tr>
            </tbody>
        </table>
    </div>

    @vite('resources/js/utility/navbar_beranda.js')
@endsection
