@extends('layouts.sidebar')
@section('title', '')
@section('content')
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
                    <th>Metode Bayar</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @for ($i = 0; $i < 8; $i++) <tr class="hover:bg-gray-50">
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
                        <span class="badge text-sm bg-red-200 text-red-700 border-0 rounded-lg px-3 py-2">
                            Belum bayar
                        </span>
                        @endif
                    </td>

                    <!-- Tombol Detail -->
                    <td>
                        <button class="btn btn-sm bg-[#2EAAA3] text-white rounded-lg" onclick="my_modal.showModal()">
                            Detail
                        </button>
                    </td>
                    </tr>
                    @endfor
            </tbody>
        </table>
    </div>
</div>




<!-- Modal -->
<dialog id="my_modal" class="modal">
    <div class="modal-box w-11/12 max-w-2xl p-0 overflow-hidden bg-white">

        <!-- Header -->
        <div class="bg-teal-500 px-6 py-4">
            <h3 class="text-white text-lg font-bold">Detail Pembayaran</h3>
        </div>

        <!-- Body -->
        <div class="p-6 space-y-3 text-gray-800 bg-white">

            <div class="grid grid-cols-3">
                <span class="font-semibold">Invoice ID</span>
                <span class="col-span-2">: ABC13590</span>
            </div>

            <div class="grid grid-cols-3">
                <span class="font-semibold">Nama Pasien</span>
                <span class="col-span-2">: Groiiiiiiii</span>
            </div>

            <div class="grid grid-cols-3">
                <span class="font-semibold">Dokter</span>
                <span class="col-span-2">: Dr. Shakila</span>
            </div>

            <div class="grid grid-cols-3 items-center">
                <span class="font-semibold">Total Tagihan</span>
                <div class="col-span-2 flex items-center gap-2">
                    <span>:</span>
                    <input type="number" class="w-full py-2 px-2 border-2 border-light-blue-500 border-opacity-100 rounded-sm"placeholder="Input jumlah pembayaran pasien" />
                </div>
            </div>

            <div class="grid grid-cols-3">
                <span class="font-semibold">Status Pembayaran</span>
                <span class="col-span-2">: Pending</span>
            </div>

        </div>

        <!-- Footer Buttons -->
        <div class="p-6 flex justify-center gap-4 bg-white">
            <form method="dialog">
                <button class="btn bg-gray-200 text-gray-700">Tutup</button>
            </form>

            <button class="btn bg-red-400 text-white hover:bg-red-500">Tolak</button>
            <button class="btn bg-green-400 text-white hover:bg-green-500">Terima</button>
        </div>

    </div>
</dialog>


@endsection
