@extends('layouts.index')

@section('title', 'pembayaran')

@section('content')

<!-- HEADER SECTION -->
<section class="bg-gradient-to-r from-indigo-900 to-sky-700 text-white px-6 md:px-20 mb-4 pt-5 pb-20 relative">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-center">
        <div>
            <span class="bg-green-300 text-green-900 px-3 py-1 rounded-full text-sm font-semibold">
                Mitra kesehatan terpercaya anda
            </span>

            <h1 class="text-4xl font-bold mt-4 leading-tight">
                Pembayaran <br>
                <span class="text-green-300">Layanan Medis</span> <br>
                Mudah dan Praktis
            </h1>

            <p class="mt-4 text-gray-100">
                Unggah bukti pembayaran dan bukti akan segera diverifikasi agar reservasi dapat diproses tanpa menunggu lama.
            </p>
        </div>

        <div class="flex justify-center">
            <img
                src="https://images.pexels.com/photos/4386466/pexels-photo-4386466.jpeg"
                class="rounded-xl shadow-lg w-80 md:w-96"
                alt="Payment Clinic">
        </div>
    </div>
</section>

<!-- FLOATING UPLOAD CARD -->
<div class="max-w-xl -mt-14 z-20 relative ms-10">
     <!-- <button class="btn bg-teal-300 text-white px-8 max-w-1xl">
                    Upload bukti pembayaran
    </button> -->
    <div class="bg-teal-300 shadow-xl rounded-xl text-center py-6">
        <h2 class="text-xl font-semibold text-white">Upload Bukti Pembayaran</h2>
    </div>
</div>


<!-- FORM PEMBAYARAN (Card Bawah) -->
<div class="max-w-4xl mx-auto mt-12 mb-20">
    <div class="bg-white shadow-lg rounded-xl p-8">

        <h2 class="text-xl font-semibold mb-6">Form Pembayaran</h2>

        <form class="grid grid-cols-1 gap-6">

            <!-- Nama -->
            <div>
                <label class="font-semibold">Nama*</label>
                <input type="text" placeholder="Masukkan nama"
                       class="input input-bordered w-full mt-1">
            </div>

            <!-- Klinik -->
            <div>
                <label class="font-semibold">Klinik*</label>
                <select class="select select-bordered w-full mt-1">
                    <option disabled selected>Pilih jenis klinik</option>
                    <option>Umum</option>
                    <option>Gigi</option>
                    <option>Kandungan</option>
                    <option>Anak</option>
                </select>
            </div>
             <div>
                <label class="font-semibold">File Bukti Bayar*</label>
                <input type="file" class="file-input file-input-bordered w-full mt-1" />
            </div>

            <p class="text-xs text-gray-500 mt-1">
                * File harus berekstensi (JPG | PNG | JPEG)
            </p>

            <!-- Keterangan -->
            <div>
                <label class="font-semibold">Keterangan</label>
                <textarea class="textarea textarea-bordered w-full" rows="3"
                          placeholder="Tambahkan catatan jika diperlukan"></textarea>
            </div>

            <div class="text-right">
                <button class="btn bg-primary text-white px-8 rounded-md h-12">
                    KIRIM BUKTI
                </button>
            </div>

        </form>
    </div>
</div>



<div class="p-6 md:p-10 bg-[#E9FAF3] min-h-screen">

    <!-- TOP BAR -->
    <div class="flex flex-col md:flex-row justify-between gap-4 items-center">

        <!-- Search -->
        <div class="w-full md:w-1/2">
            <div class="relative">
                <input type="text" placeholder="Cari"
                    class="input input-bordered w-full pl-12 rounded-full bg-white shadow-sm" />
                <i class="fa fa-search absolute left-4 top-3 text-gray-400"></i>
            </div>
        </div>

        <!-- Profile Card -->
        <div class="bg-white rounded-xl shadow flex items-center gap-3 px-6 py-3 w-full md:w-auto">
            <div class="w-12 h-12 bg-[#D5F3EE] text-[#2F8F8B] rounded-full flex items-center justify-center">
                <i class="fa fa-user text-xl"></i>
            </div>
            <div>
                <p class="font-semibold">Zia Comel</p>
                <p class="text-sm text-gray-500">admin@gmail.com</p>
            </div>
        </div>

    </div>

    <!-- NO DANA CARD -->
    <div class="bg-teal-400 text-xl text-white mt-6 rounded-xl px-6 py-4 shadow flex justify-between items-center">
        <p class="font-semibold">No dana: 081210281028</p>
        <button class="btn btn-sm bg-white text-[#288D7A] rounded-lg">Edit</button>
    </div>

    <!-- PEMBAYARAN TITLE CARD -->
    <div class="bg-teal-400 text-white mt-6 rounded-t-xl px-6 py-4 shadow flex justify-between items-center">
        <p class="font-bold text-xl">Pembayaran</p>
        <button class="btn btn-sm bg-white text-[#2EAAA3] rounded-lg">View All</button>
    </div>

    <!-- TABLE CARD -->
    <div class="bg-white shadow rounded-b-xl overflow-x-auto">
        <table class="table w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th>ID</th>
                    <th>Nama Pasien</th>
                    <th>Dokter</th>
                    <th>No Hp Klinik</th>
                    <th>Bukti Pembayaran</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @for ($i = 0; $i < 8; $i++)
                <tr class="hover:bg-gray-50">
                    <td>P1NK5682</td>
                    <td>Ariana</td>
                    <td>Dr.Shakila</td>
                    <td>08123000</td>

                    <!-- Logo Dana -->
                    <td>
                        <span class="px-3 py-1 bg-blue-600 text-white rounded-lg inline-flex items-center gap-2">
                            <span class="font-semibold tracking-wide">DANA</span>
                        </span>
                    </td>

                    <!-- Status -->
                    <td>
                        @if ($i % 2 == 0)
                        <span class="badge bg-green-200 text-green-700 border-0 rounded-lg px-3 py-2">
                            Booking
                        </span>
                        @else
                        <span class="badge bg-red-200 text-red-700 border-0 rounded-lg px-3 py-2">
                            Belum Bayar
                        </span>
                        @endif
                    </td>

                    <!-- Tombol Detail -->
                    <td>
                        <button class="btn btn-sm bg-[#2EAAA3] text-white rounded-lg">
                            Detail
                        </button>
                    </td>
                </tr>
                @endfor
            </tbody>
        </table>
    </div>
</div>

@endsection
