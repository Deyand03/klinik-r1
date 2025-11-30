@extends('layouts.sidebar')
@section('title', 'Rekam Medis')

@section('content')

<div class="px-6 w-full">
    {{-- Search Bar & Card Akun Header --}}
    <div class="flex items-center gap-6 mb-8">
        <div class="relative flex-grow bg-white">
            {{-- 1. Search Bar --}}
            <x-text-input id="search" name="search" type="text" class="w-full py-3 pl-5 pr-12 text-base 
                   rounded-full border-none shadow-md 
                   focus:outline-none focus:ring-2 focus:ring-opacity-50" placeholder="Cari" />
            {{-- Ikon Search --}}
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                stroke="currentColor"
                class="w-6 h-6 absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>

        {{-- 2. Card Keterangan Akun (User Card) --}}
        <div class="flex items-center p-5 rounded-xl shadow-md min-w-max" style="background: linear-gradient(to bottom, #4FB7B3, #81E1DD)">
            {{-- Avatar --}}
            <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center mr-3">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"
                    class="w-6 h-6 text-gray-500">
                    <path
                        d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z" />
                </svg>
            </div>
            {{-- Info Teks --}}
            <div class="text-white">
                <p class="font-bold text-sm leading-none mb-1">{{ session('user_data')['name'] ?? '-' }}</p>
                <p class="text-xs opacity-80">{{ session('user_data')['email'] ?? '-' }}</p>

            </div>
        </div>

    </div>

    {{-- Cards Statistik --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">

        {{-- Total Rekam Medis --}}
        <div class="card bg-white shadow-md p-5 flex flex-col">
            <h3 class="text-sm font-semibold text-brand-secondary">Total Rekam Medis</h3>
            <p class="text-4xl text-brand-secondary font-extrabold mt-2">{{ count($rekamMedis) }}</p>
        </div>

        {{-- Total Pasien --}}
        <div class="card bg-white shadow-md p-5 flex flex-col">
            <h3 class="text-sm font-semibold text-brand-secondary">Pasien</h3>
            <p class="text-4xl text-brand-secondary font-extrabold mt-2">
                {{ collect($rekamMedis)->pluck('kunjungan.pasien.id')->unique()->count() }}
            </p>
            <span class="text-xs text-gray-500">Total pasien berbeda</span>
        </div>

        {{-- Total Kunjungan --}}
        <div class="card bg-white shadow-md p-5 flex flex-col">
            <h3 class="text-sm font-semibold text-brand-secondary">Kunjungan</h3>
            <p class="text-4xl text-brand-secondary font-extrabold mt-2">
                {{ collect($rekamMedis)->pluck('id_kunjungan')->unique()->count() }}
            </p>
            <span class="text-xs text-gray-500">Total kunjungan</span>
        </div>

    </div>

    {{-- Tabel Rekam Medis --}}
    <div class="card bg-base-100 bg-brand-secondary shadow-md">

        {{-- Header --}}
        <div class="flex justify-between items-center mx-4">
            <div class=" text-white p-4 font-semibold rounded-t-xl">
                Daftar Rekam Medis
            </div>
            <div class="flex gap-2">
                <button onclick="my_modal_tambah_rm.showModal()"
                    class="btn btn-sm rounded-lg shadow bg-white border-none text-black transition duration-300 ease-in-out hover:bg-gray-100 hover:shadow-lg">+
                    Tambah</button>
                <button
                    class="btn btn-sm rounded-lg shadow bg-white border-none text-black transition duration-300 ease-in-out hover:bg-gray-100 hover:shadow-lg">View
                    All</button>
            </div>
        </div>

        {{-- Table --}}
        <div class="p-4 bg-white overflow-x-auto">
            <table class="table w-full">
                <thead>
                    <tr>
                        <th class="text-black">Tanggal</th>
                        <th class="text-black">Nama Pasien</th>
                        <th class="text-black">Diagnosa</th>
                        <th class="text-black">Dokter</th>
                        <th class="text-black">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($rekamMedis as $record)
                    <tr>
                        {{-- Tanggal --}}

                        <td>{{ $record['kunjungan']['tgl_kunjungan'] ?? '-' }}</td>

                        {{-- Nama Pasien --}}
                        <td>{{ $record['kunjungan']['pasien']['nama_lengkap'] ?? '-' }}</td>

                        {{-- Diagnosa --}}
                        <td>{{ $record['diagnosa'] ?? '-' }}</td>

                        {{-- Dokter --}}
                        <td>{{ $record['kunjungan']['staff']['nama'] ?? '-' }}</td>

                        {{-- Aksi --}}
                        <td>
                            {{-- Tombol Edit Memicu Modal --}}
                            <button
                                onclick="document.getElementById('my_modal_edit_rm_{{ $record['id'] }}').showModal()"
                                class="btn btn-ghost btn-xs hover:bg-brand-secondary">
                                ✏️
                            </button>

                            {{-- ====================== --}}
                            {{-- MODAL EDIT REKAM MEDIS --}}
                            {{-- ====================== --}}
                            <dialog id="my_modal_edit_rm_{{ $record['id'] }}" class="modal">
                                <div class="modal-box bg-white w-11/12 max-w-2xl p-0">

                                    {{-- Header Modal --}}
                                    <div
                                        class="bg-brand-secondary text-white p-4 font-semibold text-lg rounded-t-lg flex items-center relative">
                                        <div class="flex items-center">
                                            <span class="text-xl text-brand-tertiary font-extrabold">SI</span>
                                            <span class="text-xl text-brand-dark font-extrabold">KLINIK</span>
                                        </div>

                                        <h2 class="text-xl font-bold text-center flex-grow">Rekam Medis Pasien</h2>

                                        <form method="dialog">
                                            <button class="text-2xl px-4 font-light hover:text-gray-200">×</button>
                                        </form>
                                    </div>

                                    {{-- Konten Form Edit --}}
                                    <form method="POST" action="{{--{{ route('rekam.update', $record['id']) }}--}}" class="p-6">
                                        @csrf
                                        @method('PUT')

                                        {{-- 1. INFORMASI PASIEN (Bagian Read-Only) --}}
                                        <h3 class="text-lg font-semibold mb-4 text-brand-secondary">Informasi Pasien</h3>
                                        <div
                                            class="grid grid-cols-2 gap-y-4 gap-x-8 border-b border-gray-200 pb-4 mb-6">

                                            <div>
                                                <p class="text-xs text-gray-500">Nama :</p>
                                                <p class="font-bold">
                                                    {{ $record['kunjungan']['pasien']['nama_lengkap'] ?? '-' }}</p>
                                            </div>
                                            <div>
                                                <p class="text-xs text-gray-500">Jenis Kelamin :</p>
                                                <p class="font-bold">
                                                    {{ $record['kunjungan']['pasien']['jenis_kelamin'] ?? '-' }}</p>
                                            </div>

                                            <div>
                                                <p class="text-xs text-gray-500">No HP :</p>
                                                <p class="font-bold">
                                                    {{ $record['kunjungan']['pasien']['no_hp'] ?? '-' }}</p>
                                            </div>
                                            <div>
                                                <p class="text-xs text-gray-500">Alamat :</p>
                                                <p class="font-bold">
                                                    {{ $record['kunjungan']['pasien']['alamat'] ?? '-' }}</p>
                                            </div>

                                            <div>
                                                <p class="text-xs text-gray-500">Riwayat Alergi :</p>
                                                <p class="font-bold">
                                                    {{ $record['kunjungan']['pasien']['riwayat_alergi'] ?? '-' }}</p>
                                            </div>
                                            <div>
                                                <p class="text-xs text-gray-500">Golongan Darah :</p>
                                                <p class="font-bold">
                                                    {{ $record['kunjungan']['pasien']['golongan_darah'] ?? '-' }}</p>
                                            </div>

                                            <div>
                                                <p class="text-xs text-gray-500">Tanggal Lahir :</p>
                                                <p class="font-bold">
                                                    {{ $record['kunjungan']['pasien']['tgl_lahir'] ?? '-' }}</p>
                                            </div>

                                            {{-- Baris khusus untuk Tinggi Badan/IMT jika klinik gizi (Dikommentari dari kode asli) --}}
                                            {{-- @if ($klinik == 3)
                    <div><p class="text-xs text-gray-500">Tinggi Badan :</p><p class="font-bold">{{ $record['tinggi_badan'] ?? '-' }}
                                            cm</p>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500">IMT :</p>
                                            <p class="font-bold">{{ $record['imt'] ?? '-' }}</p>
                                        </div>
                                        @endif --}}

                                        <div class="col-span-2 text-right">
                                            {{-- Link E-Resep --}}
                                            <a onclick="document.getElementById('my_modal_eresep_{{ $record['id'] }}').showModal()"
                                                class="text-sm font-semibold text-teal-500 hover:underline cursor-pointer">
                                                E-Resep
                                            </a>
                                        </div>
                                </div>

                                {{-- 2. FIELD UTAMA REKAM MEDIS --}}

                                {{-- Anamnesa --}}
                                <div class="mb-4">
                                    <x-input-label for="anamnesa_{{ $record['id'] }}" value="Anamnesa" />
                                    <div class="relative">
                                        <textarea id="anamnesa_{{ $record['id'] }}" name="anamnesa"
                                            class="textarea bg-white textarea-bordered w-full shadow-md pr-10"
                                            rows="2">{{ old('anamnesa', $record['anamnesa'] ?? '') }}</textarea>
                                        <span class="absolute right-3 top-2 text-gray-400">✏️</span>
                                    </div>
                                </div>

                                {{-- Tensi Darah --}}
                                <div class="mb-4">
                                    <x-input-label for="tensi_darah_{{ $record['id'] }}" value="Tensi Darah" />
                                    <div class="relative">
                                        <x-text-input id="tensi_darah_{{ $record['id'] }}" name="tensi_darah"
                                            type="text" class="input bg-white input-bordered w-full shadow-md pr-10"
                                            value="{{ old('tensi_darah', $record['tensi_darah'] ?? '') }}" />
                                        <span class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400">✏️</span>
                                    </div>
                                </div>

                                {{-- Berat Badan --}}
                                <div class="mb-4">
                                    <x-input-label for="berat_badan_{{ $record['id'] }}" value="Berat Badan" />
                                    <div class="relative">
                                        <x-text-input id="berat_badan_{{ $record['id'] }}" name="berat_badan"
                                            type="text" class="input bg-white input-bordered w-full shadow-md pr-10"
                                            value="{{ old('berat_badan', $record['berat_badan'] ?? '') }}" />
                                        <span class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400">✏️</span>
                                    </div>
                                </div>

                                {{-- Suhu Badan --}}
                                <div class="mb-4">
                                    <x-input-label for="suhu_badan_{{ $record['id'] }}" value="Suhu Badan" />
                                    <div class="relative">
                                        <x-text-input id="suhu_badan_{{ $record['id'] }}" name="suhu_badan" type="text"
                                            class="input bg-white input-bordered w-full shadow-md pr-10"
                                            value="{{ old('suhu_badan', $record['suhu_badan'] ?? '') }}" />
                                        <span class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400">✏️</span>
                                    </div>
                                </div>

                                {{-- Diagnosa --}}
                                <div class="mb-4">
                                    <x-input-label for="diagnosa_{{ $record['id'] }}" value="Diagnosa" />
                                    <div class="relative">
                                        <x-text-input id="diagnosa_{{ $record['id'] }}" name="diagnosa" type="text"
                                            class="input bg-white input-bordered w-full shadow-md pr-10"
                                            value="{{ old('diagnosa', $record['diagnosa'] ?? '') }}" />
                                        <span
                                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400">✏️</span>
                                    </div>
                                </div>

                                {{-- Tindakan Medis --}}
                                <div class="mb-4">
                                    <x-input-label for="tindakan_{{ $record['id'] }}" value="Tindakan Medis" />
                                    <div class="relative">
                                        <x-text-input id="tindakan_{{ $record['id'] }}" name="tindakan"
                                            type="text" class="input bg-white input-bordered w-full shadow-md pr-10"
                                            value="{{ old('tindakan', $record['tindakan'] ?? '') }}" />
                                        <span
                                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400">✏️</span>
                                    </div>
                                </div>

                                {{-- Catatan Dokter --}}
                                <div class="mb-4">
                                    <x-input-label for="catatan_dokter_{{ $record['id'] }}" value="Catatan Dokter" />
                                    <div class="relative">
                                        <textarea id="catatan_dokter_{{ $record['id'] }}" name="catatan_dokter"
                                            class="textarea bg-white textarea-bordered w-full shadow-md pr-10"
                                            rows="2">{{ old('catatan_dokter', $record['catatan_dokter'] ?? '') }}</textarea>
                                        <span class="absolute right-3 top-2 text-gray-400">✏️</span>
                                    </div>
                                </div>

                                {{-- =================================== --}}
                                {{-- 3. KHUSUS KLINIK GIZI (KLINIK == 3) --}}
                                {{-- =================================== --}}
                                @if ($klinik == 3)
                                <hr class="my-6">
                                <h3 class="text-md font-semibold mb-4 text-brand-secondary">Pemeriksaan Gizi</h3>

                                <div class="grid grid-cols-2 gap-4">
                                    {{-- tinggi badan --}}
                                    <div>
                                        <x-input-label for="tinggi_badan"
                                            value="Tinggi Badan (cm)" />
                                        <div class="relative">
                                            <x-text-input id="tinggi_badan" name="tinggi_badan"
                                                type="number"
                                                class="input bg-white input-bordered w-full shadow-md pr-10"
                                                value="175" />
                                            <span
                                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400">✏️</span>
                                        </div>
                                    </div>
                                    
                                    {{-- imt --}}
                                    <div>
                                        <x-input-label for="imt" value="IMT" />
                                        <div class="relative">
                                            <x-text-input id="imt" name="imt" type="number"
                                                class="input bg-white input-bordered w-full shadow-md pr-10"
                                                value="22" />
                                            <span
                                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400">✏️</span>
                                        </div>
                                    </div>
                                    {{-- Lingkar Perut --}}
                                    <div>
                                        <x-input-label for="lingkar_perut"
                                            value="Lingkar Perut (cm)" />
                                        <div class="relative">
                                            <x-text-input id="lingkar_perut" name="lingkar_perut"
                                                type="number"
                                                class="input bg-white input-bordered w-full shadow-md pr-10"
                                                value="80" />
                                            <span
                                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400">✏️</span>
                                        </div>
                                    </div>

                                    {{-- Status Gizi --}}
                                    <div>
                                        <x-input-label for="status_gizi" value="Status Gizi" />
                                        <div class="relative">
                                            <x-text-input id="status_gizi" name="status_gizi"
                                                type="text" class="input bg-white input-bordered w-full shadow-md pr-10"
                                                value="Normal" />
                                            <span
                                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400">✏️</span>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                {{-- ============================= --}}
                                {{-- 4. KHUSUS KLINIK MATA (KLINIK == 2) --}}
                                {{-- ============================= --}}
                                {{-- front end --}}
                                @if ($klinik == 2)
                                <hr class="my-6">
                                <h3 class="text-md font-semibold mb-4 text-brand-secondary">Hasil Pemeriksaan Mata</h3>

                                <div class="grid grid-cols-2 gap-4">
                                    {{-- Visus OD --}}
                                    <div>
                                        <x-input-label for="visus_od_{{ $record['id'] }}" value="Visus OD" />
                                        <div class="relative">
                                            <x-text-input id="visus_od_{{ $record['id'] }}" name="visus_od" type="text"
                                                class="input bg-white input-bordered w-full shadow-md pr-10"
                                                value="{{ old('visus_od', $record['pemeriksaan_mata']['visus_od'] ?? '') }}" />
                                            <span class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400">✏️</span>
                                        </div>
                                    </div>

                                    {{-- Visus OS --}}
                                    <div>
                                        <x-input-label for="visus_os_{{ $record['id'] }}" value="Visus OS" />
                                        <div class="relative">
                                            <x-text-input id="visus_os_{{ $record['id'] }}" name="visus_os" type="text"
                                                class="input bg-white input-bordered w-full shadow-md pr-10"
                                                value="{{ old('visus_os', $record['pemeriksaan_mata']['visus_os'] ?? '') }}" />
                                            <span class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400">✏️</span>
                                        </div>
                                    </div>

                                    {{-- Sphere OD --}}
                                    <div>
                                        <x-input-label for="sphere_od_{{ $record['id'] }}" value="Sphere OD" />
                                        <div class="relative">
                                            <x-text-input id="sphere_od_{{ $record['id'] }}" name="sphere_od" type="text"
                                                class="input bg-white input-bordered w-full shadow-md pr-10"
                                                value="{{ old('sphere_od', $record['pemeriksaan_mata']['sphere_od'] ?? '') }}" />
                                            <span class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400">✏️</span>
                                        </div>
                                    </div>

                                    {{-- Sphere OS --}}
                                    <div>
                                        <x-input-label for="sphere_os_{{ $record['id'] }}" value="Sphere OS" />
                                        <div class="relative">
                                            <x-text-input id="sphere_os_{{ $record['id'] }}" name="sphere_os" type="text"
                                                class="input bg-white input-bordered w-full shadow-md pr-10"
                                                value="{{ old('sphere_os', $record['pemeriksaan_mata']['sphere_os'] ?? '') }}" />
                                            <span class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400">✏️</span>
                                        </div>
                                    </div>

                                    {{-- Cylinder OD --}}
                                    <div>
                                        <x-input-label for="cylinder_od_{{ $record['id'] }}" value="Cylinder OD" />
                                        <div class="relative">
                                            <x-text-input id="cylinder_od_{{ $record['id'] }}" name="cylinder_od" type="text"
                                                class="input bg-white input-bordered w-full shadow-md pr-10"
                                                value="{{ old('cylinder_od', $record['pemeriksaan_mata']['cylinder_od'] ?? '') }}" />
                                            <span class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400">✏️</span>
                                        </div>
                                    </div>

                                    {{-- Cylinder OS --}}
                                    <div>
                                        <x-input-label for="cylinder_os_{{ $record['id'] }}" value="Cylinder OS" />
                                        <div class="relative">
                                            <x-text-input id="cylinder_os_{{ $record['id'] }}" name="cylinder_os" type="text"
                                                class="input bg-white input-bordered w-full shadow-md pr-10"
                                                value="{{ old('cylinder_os', $record['pemeriksaan_mata']['cylinder_os'] ?? '') }}" />
                                            <span class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400">✏️</span>
                                        </div>
                                    </div>

                                    {{-- Axis OD --}}
                                    <div>
                                        <x-input-label for="axis_od_{{ $record['id'] }}" value="Axis OD" />
                                        <div class="relative">
                                            <x-text-input id="axis_od_{{ $record['id'] }}" name="axis_od" type="text"
                                                class="input bg-white input-bordered w-full shadow-md pr-10"
                                                value="{{ old('axis_od', $record['pemeriksaan_mata']['axis_od'] ?? '') }}" />
                                            <span class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400">✏️</span>
                                        </div>
                                    </div>

                                    {{-- Axis OS --}}
                                    <div>
                                        <x-input-label for="axis_os_{{ $record['id'] }}" value="Axis OS" />
                                        <div class="relative">
                                            <x-text-input id="axis_os_{{ $record['id'] }}" name="axis_os" type="text"
                                                class="input bg-white input-bordered w-full shadow-md pr-10"
                                                value="{{ old('axis_os', $record['pemeriksaan_mata']['axis_os'] ?? '') }}" />
                                            <span class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400">✏️</span>
                                        </div>
                                    </div>

                                    {{-- PD --}}
                                    <div>
                                        <x-input-label for="pd_{{ $record['id'] }}" value="PD" />
                                        <div class="relative">
                                            <x-text-input id="pd_{{ $record['id'] }}" name="pd" type="text"
                                                class="input bg-white input-bordered w-full shadow-md pr-10"
                                                value="{{ old('pd', $record['pemeriksaan_mata']['pd'] ?? '') }}" />
                                            <span class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400">✏️</span>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                <hr class="my-6">

                                {{-- ====================== --}}
                                {{--   BAGIAN EDIT E-RESEP  --}}
                                {{-- ====================== --}}
                                <h3 class="text-md font-semibold mb-4 text-brand-secondary">E-Resep (belum selesai)</h3>
                                 {{-- lom kelar  --}}
                                

                                <dialog id="my_modal_eresep_{{ $record['id'] }}" class="modal">
                                    <div class="modal-box bg-white w-11/12 max-w-lg p-0">

                                        {{-- Header Modal (Disesuaikan dengan branding) --}}
                                        <div
                                            class="bg-brand-secondary text-white p-4 font-semibold text-lg rounded-t-lg flex items-center relative">
                                            <div class="flex items-center">
                                                <span class="text-xl text-brand-tertiary font-extrabold">SI</span>
                                                <span class="text-xl text-brand-dark font-extrabold">KLINIK</span>
                                            </div>

                                            <h2 class="text-xl font-bold text-center flex-grow">E-Resep</h2>

                                            <form method="dialog">
                                                <button class="text-2xl px-4 font-light hover:text-gray-200">×</button>
                                            </form>
                                        </div>

                                        {{-- Konten Resep --}}
                                        <div class="p-6">

                                            {{-- ID Rekam Medis dan Tanggal --}}
                                            <div class="flex justify-between text-sm mb-4 border-b pb-2">
                                                <p>ID Rekam Medis : <span
                                                        class="font-semibold">{{ $record['id'] ?? 'Null' }}</span>
                                                </p>
                                                <p>{{ now()->format('d F Y') }}</p>
                                            </div>

                                            {{-- Informasi Pasien --}}
                                            <div class="mb-6 border-b pb-4">
                                                <p class="text-gray-500 text-sm">Nama Pasien : <span
                                                        class="text-black font-semibold">{{ $record['kunjungan']['pasien']['nama_lengkap'] ?? '-' }}</span>
                                                </p>
                                                <p class="text-gray-500 text-sm">Umur : <span class="text-black font-semibold">{{ intval(\Carbon\Carbon::parse($record['kunjungan']['pasien']['tgl_lahir'])->diffInYears(\Carbon\Carbon::now())) ?? '-' }} tahun</span></p>
                                            </div>

                                            {{-- Daftar Obat (Contoh Looping Data Resep) --}}
                                            <h3 class="text-lg font-bold mb-4">Daftar Obat</h3>

                                            {{-- @php
                                            
                                            $resep = $record['resep'] ?? [
                                            ['nama_obat' => 'Zithromax 500 mg', 'jumlah' => 3, 'satuan' => 'Kapsul',
                                            'aturan_minum' => '1 x 2 Kapsul sehari - Setelah makan', 'catatan' =>
                                            'Antibiotik, habiskan semua sesuai resep.'],
                                            ['nama_obat' => 'Paracetamol 500 mg', 'jumlah' => 10, 'satuan' => 'Tablet',
                                            'aturan_minum' => '3 x 1 Tablet sehari - Saat demam', 'catatan' =>
                                            'Jika demam sudah turun, hentikan penggunaan.']
                                            ];
                                            @endphp --}}

                                        @forelse ($record['resep'] as $r)
                                            <div class="border-b border-gray-100 py-3">
                                                <p class="text-base font-bold text-gray-800">
                                                    {{ $r['obat']['nama_obat'] ?? 'Nama Obat' }} -
                                                    {{ $r['jumlah'] ?? '-' }} {{ $r['obat']['satuan'] ?? '' }}
                                                </p>
                                                <p class="text-sm text-gray-700">Aturan Pakai:
                                                    {{ $r['aturan_pakai'] ?? 'Belum ada' }}</p>
                                            </div>
                                        @empty
                                                <div class="text-center py-4 text-gray-500 italic">
                                                    Belum ada resep obat yang ditambahkan.
                                                </div>
                                            @endforelse
                                        </div>
                                    </div>
                                </dialog>

                                {{-- ============================= --}}
                                {{-- AKHIR BAGIAN E-RESEP --}}
                                {{-- ============================= --}}


                                {{-- Tombol Kirim --}}
                                <div class="mt-6 text-right">
                                    {{-- Tombol Unduh / Simpan --}}
                                    <button type="submit"
                                        class="btn bg-teal-500 hover:bg-teal-600 text-white border-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="2" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                        </svg>
                                        Simpan Perubahan
                                    </button>
                                </div>
                                </form>

                                {{-- Modal Backdrop --}}
                                <form method="dialog" class="modal-backdrop">
                                    <button>tutup</button>
                                </form>
                              </div>
                           </dialog>
                              </td>
                         </tr>
                     @empty
                          <tr>
                            <td colspan="5" class="text-center py-4 text-gray-500">
                                Tidak ada data rekam medis
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
            </table>
        </div>
    </div>
</div>

<dialog id="my_modal_tambah_rm" class="modal">
    <div class="modal-box bg-white w-11/12 max-w-2xl p-0">

        {{-- Header Modal --}}
        <div
            class="bg-brand-secondary text-white p-4 font-semibold text-lg rounded-t-lg flex justify-between items-center">

            {{-- Logo --}}
            <div class="flex items-center">
                <span class="text-xl text-brand-tertiary font-extrabold">SI</span>
                <span class="text-xl text-brand-dark font-extrabold">KLINIK</span>
            </div>

            {{-- Judul --}}
            <h2 class="text-xl font-bold">Daftar Rekam Medis</h2>

            {{-- Tombol Close (X) --}}
            <form method="dialog">
                <button class="text-2xl px-4 font-light hover:text-gray-200">×</button>
            </form>

        </div>

        {{-- Konten Form --}}
        <form method="POST" action="{{ route('rekam.store') }}" class="p-6">
            @csrf

            {{-- No Kunjungan --}}
            <div class="mb-4">
                <x-input-label for="no_kunjungan" value="No Kunjungan :" />
                <select id="no_kunjungan" name="no_kunjungan" class="select bg-white select-bordered w-full shadow-md">
                    <option disabled selected>Pilih No. Kunjungan</option>
                    {{-- looping kunjungan --}}
                    @foreach ($kunjungan as $k)
                    <option value="{{ $k['id'] }}">
                        {{ 'No-'.$k['id'] }} — {{ $k['pasien']['nama_lengkap'] ?? 'Tanpa Nama' }}
                    </option>
                    @endforeach
                </select>
            </div>

            {{-- Anamnesa --}}
            <div class="mb-4">
                <x-input-label for="anamnesa" value="Anamnesa :" />
                <x-text-input id="anamnesa" name="anamnesa" type="text"
                    class="input bg-white input-bordered w-full shadow-md" />
            </div>

            {{-- Tensi Darah --}}
            <div class="mb-4">
                <x-input-label for="tensi_darah" value="Tensi Darah :" />
                <x-text-input id="tensi_darah" name="tensi_darah" type="text"
                    class="input bg-white input-bordered w-full shadow-md" />
            </div>
            {{-- berat badan --}}
            <div class="mb-4">
                <x-input-label for="berat_badan" value="Berat Badan :" />
                <x-text-input id="berat_badan" name="berat_badan" type="text"
                    class="input bg-white input-bordered w-full shadow-md" />
            </div>
            {{-- suhu badan --}}
            <div class="mb-4">
                <x-input-label for="suhu_badan" value="Suhu Badan :" />
                <x-text-input id="suhu_badan" name="suhu_badan" type="text"
                    class="input bg-white input-bordered w-full shadow-md" />
            </div>

            {{-- Diagnosa --}}
            <div class="mb-4">
                <x-input-label for="diagnosa" value="Diagnosa :" />
                <x-text-input id="diagnosa" name="diagnosa" type="text"
                    class="input bg-white input-bordered w-full shadow-md" />
            </div>

            {{-- Tindakan Medis --}}
            <div class="mb-4">
                <x-input-label for="tindakan" value="Tindakan Medis :" />
                <x-text-input id="tindakan" name="tindakan" type="text"
                    class="input bg-white input-bordered w-full shadow-md" />
            </div>

            {{-- Catatan Dokter --}}
            <div class="mb-4">
                <x-input-label for="catatan_dokter" value="Catatan Dokter :" />
                <textarea id="catatan_dokter" name="catatan_dokter"
                    class="textarea bg-white textarea-bordered w-full shadow-md"></textarea>
            </div>

            {{-- ================== --}}
            {{-- KHUSUS KLINIK MATA --}}
            {{-- ================== --}}
            @if ($klinik == 2)
            <hr class="my-6">
            <h3 class="text-md font-semibold mb-4">Hasil Pemeriksaan Mata</h3>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <x-input-label for="visus_od" value="Visus OD" />
                    <x-text-input id="visus_od" name="visus_od" type="text"
                        class="input bg-white input-bordered w-full shadow-md" />
                </div>

                <div>
                    <x-input-label for="visus_os" value="Visus OS" />
                    <x-text-input id="visus_os" name="visus_os" type="text"
                        class="input bg-white input-bordered w-full shadow-md" />
                </div>

                <div>
                    <x-input-label for="sphere_od" value="Sphere OD" />
                    <x-text-input id="sphere_od" name="sphere_od" type="text"
                        class="input bg-white input-bordered w-full shadow-md" />
                </div>
                <div>
                    <x-input-label for="sphere_os" value="Sphere OS" />
                    <x-text-input id="sphere_os" name="sphere_os" type="text"
                        class="input bg-white input-bordered w-full shadow-md" />
                </div>

                <div>
                    <x-input-label for="cylinder_od" value="Cylinder OD" />
                    <x-text-input id="cylinder_od" name="cylinder_od" type="text"
                        class="input bg-white input-bordered w-full shadow-md" />
                </div>
                <div>
                    <x-input-label for="cylinder_os" value="Cylinder OS" />
                    <x-text-input id="cylinder_os" name="cylinder_os" type="text"
                        class="input bg-white input-bordered w-full shadow-md" />
                </div>
                <div>
                    <x-input-label for="axis_od" value="Axis OD" />
                    <x-text-input id="axis_od" name="axis_od" type="text"
                        class="input bg-white input-bordered w-full shadow-md" />
                </div>
                <div>
                    <x-input-label for="axis_os" value="Axis OS" />
                    <x-text-input id="axis_os" name="axis_os" type="text"
                        class="input bg-white input-bordered w-full shadow-md" />
                </div>
                <div>
                    <x-input-label for="pd" value="PD" />
                    <x-text-input id="pd" name="pd" type="text"
                        class="input bg-white input-bordered w-full shadow-md" />
                </div>
            </div>
            @endif

            {{-- ============================= --}}
            {{-- KHUSUS KLINIK GIZI --}}
            {{-- ============================= --}}
            @if ($klinik == 3)
            <hr class="my-6">
            <h3 class="text-md font-semibold mb-4">Pemeriksaan Gizi</h3>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <x-input-label for="tinggi_badan" value="Tinggi Badan (cm)" />
                    <x-text-input id="tinggi_badan" name="tinggi_badan" type="number"
                        class="input bg-white input-bordered w-full shadow-md" />
                </div>

                <div>
                    <x-input-label for="imt" value="IMT" />
                    <x-text-input id="imt" name="imt" type="text"
                        class="input bg-white input-bordered w-full shadow-md" />
                </div>

                <div>
                    <x-input-label for="lingkar_perut" value="Lingkar Perut (cm)" />
                    <x-text-input id="lingkar_perut" name="lingkar_perut" type="number"
                        class="input bg-white input-bordered w-full shadow-md" />
                </div>

                <div>
                    <x-input-label for="status_gizi" value="Status Gizi" />
                    <x-text-input id="status_gizi" name="status_gizi" type="text"
                        class="input bg-white input-bordered w-full shadow-md" />
                </div>
            </div>
            @endif

            {{-- ======= --}}
            {{-- E-Resep --}}
            {{-- ======= --}}
            <hr class="my-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-md font-semibold">E-Resep</h3>
                {{-- Tombol Tambah --}}
                <button type="button" id="tambah-resep-btn" class="btn btn-sm btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Obat
                </button>
            </div>

            <div id="resep-container">

                <div class="resep-item p-4 mb-4 rounded-lg bg-white shadow-md relative" data-index="0">
                    <h4 class="font-bold text-sm mb-3 text-brand-secondary resep-nomor">Obat #1</h4>
                    <div class="mb-4">
                        <x-input-label value="Nama Obat :" />
                        <select name="resep[0][id_obat]"
                            class="select bg-white select-bordered w-full shadow-md resep-select">
                            <option disabled selected>Pilih Obat</option>
                            @foreach($obat as $o)
                            @if(is_array($o))
                            <option value="{{ $o['id'] }}">
                                {{ 'Kode-Obat-'.$o['id'] }} — {{ $o['nama_obat'] ?? 'Tanpa Nama' }}
                            </option>
                            @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="mb-4">
                            <x-input-label value="Jumlah :" />
                            <x-text-input name="resep[0][jumlah]" type="text"
                                class="input bg-white input-bordered w-full shadow-md" placeholder="Contoh: 10" />
                        </div>
                        <div class="mb-4">
                            <x-input-label value="Aturan Pakai :" />
                            <x-text-input name="resep[0][aturan_pakai]" type="text"
                                class="input bg-white input-bordered w-full shadow-md"
                                placeholder="Contoh: 3x sehari 1 tablet" />
                        </div>
                    </div>
                </div>
            </div>

            <template id="resep-template">
                <div class="resep-item p-4 mb-4 rounded-lg bg-white shadow-md relative">
                    <h4 class="font-bold text-sm mb-3 text-brand-secondary resep-nomor">Obat #X</h4>

                    <div class="mb-4">
                        <x-input-label value="Nama Obat :" />
                        <select name="resep[X][id_obat]"
                            class="select bg-white select-bordered w-full shadow-md resep-select-template">

                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="mb-4">
                            <x-input-label value="Jumlah :" />
                            <x-text-input name="resep[X][jumlah]" type="text"
                                class="input bg-white input-bordered w-full shadow-md" placeholder="Contoh: 10" />
                        </div>
                        <div class="mb-4">
                            <x-input-label value="Aturan Pakai :" />
                            <x-text-input name="resep[X][aturan_pakai]" type="text"
                                class="input bg-white input-bordered w-full shadow-md"
                                placeholder="Contoh: 3x sehari 1 tablet" />
                        </div>
                    </div>
                </div>
            </template>
            <div class="mt-6 text-right">
                <button type="submit" class="btn bg-teal-500 hover:bg-teal-600 text-white border-none">Kirim</button>
            </div>

        </form>
    </div>
</dialog>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const container = document.getElementById('resep-container');
        const template = document.getElementById('resep-template');
        const addButton = document.getElementById('tambah-resep-btn');

        // Ambil opsi dari select pertama yang sudah di-render oleh Blade
        const optionsHtml = container.querySelector('.resep-select').innerHTML;

        // Fungsi untuk mendapatkan index resep berikutnya (berdasarkan jumlah item)
        function getNextIndex() {
            const count = container.querySelectorAll('.resep-item').length;
            return count;
        }

        // Fungsi untuk memperbarui nama atribut, nomor resep, dan menambahkan tombol hapus
        function updateItem(newItem, index) {
            // 1. Update nama input (mengganti [X] dengan index yang benar)
            newItem.querySelectorAll('select, input').forEach(input => {
                if (input.name) {
                    input.name = input.name.replace('[X]', `[${index}]`);
                }
                input.value = ''; // Mengosongkan value
            });

            // 2. Update nomor resep di header
            newItem.querySelector('.resep-nomor').textContent = `Resep #${index + 1}`;

            // 3. Masukkan opsi ke select baru
            const selectElement = newItem.querySelector('.resep-select-template');
            if (selectElement) {
                selectElement.innerHTML = optionsHtml;
                selectElement.classList.remove('resep-select-template');
            }

            // 4. Tambahkan tombol hapus (HANYA UNTUK ITEM YANG BARU DIBUAT)
            if (index > 0) { // Hanya tambahkan tombol hapus jika bukan item pertama (index 0)
                const deleteButtonHtml = `
                <button type="button" class="hapus-resep-btn absolute top-2 right-2 btn btn-xs btn-error btn-circle text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            `;
                newItem.insertAdjacentHTML('afterbegin', deleteButtonHtml);

                // Tambahkan event listener untuk tombol hapus
                newItem.querySelector('.hapus-resep-btn').addEventListener('click', function () {
                    newItem.remove();
                    reNumberResepItems();
                });
            }
        }

        // Event listener untuk tombol 'Tambah Obat'
        addButton.addEventListener('click', function () {
            const index = getNextIndex();

            // Kloning template
            const newItem = template.content.cloneNode(true).querySelector('.resep-item');

            updateItem(newItem, index);

            // Masukkan elemen baru ke container
            container.appendChild(newItem);
        });

        // Fungsi untuk menomori ulang input setelah penghapusan
        function reNumberResepItems() {
            // Ambil semua item, termasuk item statis pertama
            container.querySelectorAll('.resep-item').forEach((item, index) => {
                // Update nama input
                item.querySelectorAll('select, input').forEach(input => {
                    if (input.name) {
                        // Cari dan ganti index array yang lama
                        // Regex: /resep\[\d+\]/ mencari 'resep[' diikuti angka berapapun dan ']'
                        input.name = input.name.replace(/resep\[\d+\]/, `resep[${index}]`);
                    }
                });
                // Update header nomor (khusus item kedua dst)
                const header = item.querySelector('.resep-nomor');
                if (header) {
                    header.textContent = index === 0 ? 'Resep #1 (Utama)' : `Resep #${index + 1}`;
                }
            });
        }
    });

</script>
@endsection
