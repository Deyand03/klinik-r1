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
    <div class="overflow-x-auto flex justify-center my-6">
    <table class="w-full max-w-7xl shadow-xl rounded-lg overflow-hidden">

        <thead class="bg-blue-800 text-white">
            <tr>
                <th class="px-4 py-3 text-sm font-normal text-left tracking-wider">No. Antrian</th>
                <th class="px-4 py-3 text-sm font-normal text-left tracking-wider">Klinik</th>
                <th class="px-4 py-3 text-sm font-normal text-left tracking-wider">Nama Dokter</th>
                <th class="px-4 py-3 text-sm font-normal text-left tracking-wider">Tgl Kunjungan</th>
                <th class="px-4 py-3 text-sm font-normal text-left tracking-wider">Keluhan</th>
                <th class="px-4 py-3 text-sm font-normal text-center tracking-wider">Status</th>
                <th class="px-4 py-3 text-sm font-normal text-center tracking-wider">Surat Rujukan</th>
            </tr>
        </thead>

        <tbody class="divide-y divide-gray-200 bg-white">

            <tr class="hover:bg-gray-50 transition duration-150">
                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">001</td>
                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">Umum</td>
                <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">dr. Benny Wijaya</td>
                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">12 Des 2025</td>
                <td class="px-4 py-3 text-sm text-gray-700">Sakit Kepala</td>
                <td class="px-4 py-3 whitespace-nowrap text-center">
                    <span class="px-3 py-1 text-xs font-medium bg-green-100 text-green-700 rounded-full">Selesai</span>
                </td>
                <td class="px-4 py-3 whitespace-nowrap text-center text-blue-600 hover:text-blue-800">
                    <a href="#" class="font-medium hover:underline">123123.pdf</a>
                </td>
            </tr>

            <tr class="hover:bg-gray-50 transition duration-150">
                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">002</td>
                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">Gigi</td>
                <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">drg. Deya Seprina</td>
                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">20 Nov 2025</td>
                <td class="px-4 py-3 text-sm text-gray-700">Sakit Gigi</td>
                <td class="px-4 py-3 whitespace-nowrap text-center">
                    <span class="px-3 py-1 text-xs font-medium bg-green-100 text-green-700 rounded-full">Selesai</span>
                </td>
                <td class="px-4 py-3 whitespace-nowrap text-center text-blue-600 hover:text-blue-800">
                    <a href="#" class="font-medium hover:underline">234566.pdf</a>
                </td>
            </tr>

            <tr class="hover:bg-gray-50 transition duration-150">
                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">003</td>
                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">Mata</td>
                <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">dr. Medina, Sp.M</td>
                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">30 Okt 2025</td>
                <td class="px-4 py-3 text-sm text-gray-700">Mata Merah</td>
                <td class="px-4 py-3 whitespace-nowrap text-center">
                    <span class="px-3 py-1 text-xs font-medium bg-green-100 text-green-700 rounded-full">Selesai</span>
                </td>
                <td class="px-4 py-3 whitespace-nowrap text-center text-blue-600 hover:text-blue-800">
                    <a href="#" class="font-medium hover:underline">987120.pdf</a>
                </td>
            </tr>
            </tbody>
    </table>
</div>


@endsection
