@extends('layouts.sidebar')

@section('title', 'Ruang Dokter')

@section('content')
{{-- DUMMY DATA --}}
@php
$antrian = [
[
'id' => 1,
'no_antrian' => 'A-001',
'nama' => 'Andi Pratama',
'anamnesa' => 'Sakit kepala belakang, mual, pusing.',
'vital' => 'BB: 65kg, TD: 130/90, Suhu: 37°C',
],
];
@endphp
<p style="display:none" id="id-dokter">{{ Session::get('user_data')['staff']['id'] }}</p>
<div x-data="{
        openModal: false,
        selectedPasien: null,
        openPeriksa(item) {
            this.selectedPasien = item;
            this.openModal = true;
        }
    }">
    <!-- {{print_r($dataKunjungan)}} -->
    <!-- {{print_r(session()->all())}} -->
    @if(Session::has('message'))
    @php
    $status = Session::get('status');
    $isSuccess = $status === 'success';

    // Tentukan kelas warna berdasarkan status
    $bgClass = $isSuccess ? 'bg-green-100 border-green-400 text-green-700' : 'bg-red-100 border-red-400 text-red-700';
    $iconClass = $isSuccess ? 'text-green-500' : 'text-red-500';
    $title = $isSuccess ? 'Berhasil!' : 'Gagal!';
    $iconPath = $isSuccess
    ? '
    <path
        d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4z" />
    <path d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm-1-8h2v4H9v-4zm0-2h2v2H9V8z" />'
    : '
    <path d="M10 20c-5.52 0-10-4.48-10-10S4.48 0 10 0s10 4.48 10 10-4.48 10-10 10zm-1-14h2v5H9V6zm0 7h2v2H9v-2z" />';
    @endphp

    <div role="alert" class="px-4 py-3 rounded-lg flex items-center shadow-md border mb-6 {{ $bgClass }}">

        {{-- Icon --}}
        <div class="mr-3">
            <svg class="h-5 w-5 fill-current {{ $iconClass }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                {!! $iconPath !!}
            </svg>
        </div>

        {{-- Pesan --}}
        <div>
            <p class="font-bold">{{ $title }}</p>
            <p class="text-sm">{{ Session::get('message') }}</p>
        </div>
    </div>
    @endif

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-[#2C3753]">Ruang Praktik</h1>
                <p class="text-gray-500 text-sm">Pasien yang siap diperiksa.</p>
            </div>
            <div class="badge badge-secondary badge-outline font-bold text-purple-600">Filter: Menunggu Dokter</div>
        </div>

        <div class="overflow-x-auto">
            <table class="table w-full">
                <thead class="bg-purple-50 text-purple-800 uppercase text-xs font-bold">
                    <tr>
                        <th class="py-4 pl-4">Antrian</th>
                        <th>Data Pasien</th>
                        <th>Data Medis (Dari Perawat)</th>
                        <th class="text-right pr-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">

                    @foreach ($dataKunjungan['antrian'] as $kunjungan)
                    <tr class="hover:bg-purple-50/30 transition">
                        <td class="pl-4 font-mono font-bold text-lg text-purple-600">{{ $kunjungan['no_antrian'] }}</td>
                        <td>
                            <div class="font-bold text-gray-800">{{ $kunjungan['nama_lengkap'] }}</div>
                        </td>
                        <td>
                            <div class="text-sm font-medium"></div>
                            <div class="text-xs text-purple-600 bg-purple-100 px-2 py-0.5 rounded w-fit mt-1">
                                {{ $kunjungan['keluhan'] }}</div>
                        </td>
                        <td class="text-right pr-4">
                            <button @click="openPeriksa" data-id="{{ $kunjungan['id'] }}"
                                class="btn btn-sm btn-periksa bg-purple-600 hover:bg-purple-700 text-white border-none shadow-md shadow-purple-200 rounded-lg">
                                Periksa
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- MODAL PERIKSA --}}
   <div x-data="{ isRujuk: false }" x-show="openModal" style="display: none;"
    class="fixed inset-0 z-50 overflow-y-auto" aria-modal="true">
    {{-- Latar belakang gelap --}}
    <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm" @click="openModal = false"></div>

    {{-- Kontainer Utama Modal --}}
    <div class="flex min-h-full items-center justify-center p-4" id="container-modal">
        <div
            class="relative bg-white w-full max-w-3xl rounded-xl shadow-2xl transform transition-all duration-300 overflow-hidden max-h-[90vh] flex flex-col">

            {{-- Header Modal yang Dipercantik (Akan tetap di atas) --}}
            <div class="bg-purple-700 px-6 py-4 flex justify-between items-center text-white flex-shrink-0">
                <div class="flex items-center space-x-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <h3 class="text-xl font-extrabold">Pemeriksaan Medis Pasien</h3>
                </div>
                <button @click="openModal = false"
                    class="text-white hover:bg-purple-600 p-2 rounded-full transition duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Isi Modal (Akan di-scroll) --}}
            <div class="p-6 space-y-6 overflow-y-auto flex-grow">

                {{-- Review Data Perawat (Card Style) --}}
                <div class="bg-blue-50 p-5 rounded-xl border border-blue-200 shadow-inner">
                    <div class="flex items-center mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 mr-2"
                            viewBox="0 0 20 20" fill="currentColor">
                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                            <path fill-rule="evenodd"
                                d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h.01a1 1 100-2H10zm3 0a1 1 0 000 2h.01a1 1 100-2H13z"
                                clip-rule="evenodd" />
                        </svg>
                        <p class="font-extrabold text-blue-800 uppercase text-sm">Data dari Perawat</p>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-700">
                        <div>
                            <p class="font-bold text-gray-500 mb-0.5">Anamnesa:</p>
                            <p class="pl-2 border-l-4 border-blue-400 italic" id="anamnesa">Pasien mengeluh sakit
                                kepala berdenyut sejak 2 hari, disertai mual ringan. Tidak ada demam.</p>
                        </div>
                        <div>
                            <p class="font-bold text-gray-500 mb-0.5">Vital Signs:</p>
                            <p class="pl-2 border-l-4 border-blue-400 italic" id="vital-signs">TD: 145/90 mmHg, N:
                                88x/menit, S: 36.8°C, RR: 18x/menit.</p>
                        </div>
                    </div>
                </div>

                <hr class="border-gray-100">

                {{-- Form Pemeriksaan Dokter --}}
                <form action="" id="form-diagnosa" method="POST" class="space-y-6">
                    @csrf
                    <input type="hidden" name="id_staff" value="{{ Session::get('user_data')['staff']['id'] }}">
                    <input type="hidden" name="rekam_medis_id" id="rekam_medis">

                    {{-- Diagnosa --}}
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-bold text-gray-700">🩺 Diagnosa Dokter</span>
                        </label>
                        <input type="text" name="diagnosa"
                            class="input input-bordered input-primary border border-purple-400 rounded-sm w-full"
                            placeholder="Contoh: Hypertensi Grade 1, Common Cold..." required>
                    </div>

                    {{-- Tindakan yang Dianjurkan oleh Dokter (NEW INPUT) --}}
                    <div class="form-control">
                        <label class="label mb-2">
                            <span class="label-text font-bold text-gray-700">💉 Tindakan yang Dianjurkan (Rencana Tatalaksana)</span>
                        </label>
                        <textarea name="tindakan"
                            class="textarea textarea-bordered h-24 w-full border border-purple-400 rounded-sm"
                            placeholder="Contoh: Nebulisasi, Injeksi Ketorolac, Pemasangan IV line, Observasi 6 jam, dll." required></textarea>
                    </div>

                    {{-- OPSI RUJUKAN --}}
                    <div class="flex items-center">
                        <input type="checkbox" id="checkbox-rujuk" x-model="isRujuk" name="is_rujuk"
                            class="checkbox checkbox-sm checkbox-primary mr-2" value="1">
                        <label for="checkbox-rujuk" class="label-text font-bold text-amber-600">
                            Rujuk Pasien ke Fasilitas Kesehatan Lain
                        </label>
                    </div>

                    {{-- INPUT RUJUKAN (Hanya muncul jika isRujuk TRUE) --}}
                    <div x-show="isRujuk" x-cloak
                        class="border border-amber-300 p-4 rounded-lg bg-amber-50 space-y-4 transition ease-in-out duration-300">
                        <h4 class="text-md font-extrabold text-amber-700 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm-7-9a1 1 0 011-1h1a1 1 0 011 1v1a1 1 0 01-1 1H4a1 1 0 01-1-1v-1zm14 0a1 1 0 011-1h1a1 1 0 011 1v1a1 1 0 01-1 1h-1a1 1 0 01-1-1v-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            Detail Rujukan
                        </h4>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            {{-- Input Poli Tujuan --}}
                            <div class="form-control">
                                <label class="label"><span class="label-text text-gray-700">Poli
                                        Tujuan</span></label>
                                <input type="text" name="poli"
                                    class="input input-bordered w-full border-amber-400 rounded-sm"
                                    placeholder="Contoh: Spesialis Jantung">
                            </div>

                            {{-- Input Rumah Sakit Tujuan --}}
                            <div class="form-control">
                                <label class="label"><span class="label-text text-gray-700">Rumah Sakit
                                        Tujuan</span></label>
                                <input type="text" name="tujuan"
                                    class="input input-bordered w-full border-amber-400 rounded-sm"
                                    placeholder="Contoh: RSUD Dr. Soetomo">
                            </div>
                        </div>

                        {{-- Input Alasan Rujukan --}}
                        <div class="form-control">
                            <label class="label"><span class="label-text text-gray-700">Alasan
                                        Rujukan</span></label>
                            <textarea name="alasan"
                                class="textarea textarea-bordered h-20 w-full border-amber-400 rounded-sm"
                                placeholder="Tulis alasan medis singkat kenapa pasien perlu dirujuk..."></textarea>
                        </div>
                    </div>

                    <hr class="border-gray-100">

                    {{-- Resep Obat (Dinamis / Baris Obat) --}}
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-bold text-gray-700">💊 Resep Obat</span>
                        </label>
                        
                        <div class="space-y-3">
                            {{-- Baris Obat 1 (Ulangi ini untuk item obat tambahan) --}}
                            <div class="flex gap-3 items-end">
                                <div class="w-full">
                                    <label class="label-text text-xs text-gray-500 mb-0.5 block">Nama Obat</label>
                                    
                                    <select name="obat"
                                        class="select select-bordered w-full rounded-sm border-purple-400 border">
                                        <option disabled selected class="bg-indigo-400 text-white fw-semibold p-4">
                                            Pilih Obat dari Apotek</option>
                                        @foreach($dataKunjungan['obat'] as $obat)
                                        <option value="{{$obat['id']}}"
                                            class="bg-indigo-400 text-white fw-semibold p-4">
                                            {{$obat['nama_obat']}} (Rp {{$obat['harga']}})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="w-24">
                                    <label class="label-text text-xs text-gray-500 mb-0.5 block">Jumlah</label>
                                    <input type="number" name="jumlah"
                                        class="input input-bordered w-full border rounded-sm border-purple-400"
                                        placeholder="Qty" min="1">
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 italic mt-1">* Pilih obat dari stok apotek. Anda bisa
                                menambahkan baris resep lain.</p>
                        </div>
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-bold text-gray-700">💊 Harga</span>
                        </label>
                        <div class="space-y-3">
                            {{-- Baris Harga --}}
                            <div class="flex gap-3 items-end">
                                <div class="w-full">
                                    <label class="label-text text-xs text-gray-500 mb-0.5 block">Harga obat</label>
                                    <input type="number" name="harga"
                                        class="input input-bordered w-full border rounded-sm border-purple-400"
                                        placeholder="Masukkan harga" min="1">
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 italic mt-1">* Pilih obat dari stok apotek. Anda bisa
                                menambahkan baris resep lain.</p>
                        </div>
                    </div>

                    {{-- Catatan --}}
                    <div class="form-control">
                        <label class="label mb-2">
                            <span class="label-text font-bold text-gray-700">📝 Catatan / Saran Tambahan</span>
                        </label>
                        <textarea name="catatan_dokter"
                            class="textarea textarea-bordered h-24 w-full border border-purple-400 rounded-sm"
                            placeholder="Istirahat cukup, kurangi makanan berminyak, kontrol seminggu lagi..."></textarea>
                    </div>

                    {{-- Aksi Modal (Akan tetap di bawah) --}}
                    <div class="modal-action flex justify-end pt-4 border-t border-gray-100 flex-shrink-0">
                        <button type="button" @click="openModal = false"
                            class="btn btn-ghost hover:bg-gray-100 px-6">Batal</button>
                        <button id="btn-selesai" type="submit"
                            class="btn bg-purple-600 hover:bg-purple-700 text-white border-none shadow-md px-6">
                            Selesai & Lanjutkan ke Kasir
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="{{asset('js/kunjungan.js')}}"></script>
@endsection