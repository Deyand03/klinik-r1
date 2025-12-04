@extends('layouts.sidebar')

@section('title', 'Perawat - Tanda Vital')

@section('content')
    {{-- Ambil data dari controller --}}
    @php
        // $antrian dikirim dari DashboardController@index
        // Contoh: $antrian = [
        //     ['id'=>1,'no_antrian'=>'A-001','nama_lengkap'=>'Andi Pratama','keluhan'=>'Sakit kepala','jenis_kelamin'=>'Laki-laki','usia'=>'25 Thn']
        // ];
    @endphp

    <div x-data="{
                                                                                                                    openModal: false,
                                                                                                                    selectedPasien: null,
                                                                                                                    openInput(item) {
                                                                                                                        this.selectedPasien = item;
                                                                                                                        this.openModal = true;
                                                                                                                    }
                                                                                                                }">

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-[#2C3753]">Unit Keperawatan</h1>
                    <p class="text-gray-500 text-sm">Pemeriksaan tanda vital sebelum masuk ruang dokter.</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="table w-full border border-gray-300 border-collapse">
                    <thead class="bg-yellow-50 text-yellow-800 uppercase text-xs font-bold">
                        <tr>
                            <th class="py-4 pl-4 border border-gray-200 text-center">Antrian</th>
                            <th class=" border border-gray-200 text-center">Pasien</th>
                            <th class="border border-gray-200 text-center">Keluhan Awal (Dari Web)</th>
                            <th class="py-4 pl-4 border border-gray-200 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 border border-gray-300">
                        @foreach ($antrian as $item)
                            <tr class="hover:bg-yellow-50/30 transition">
                                <td class="pl-4 font-mono font-bold text-lg text-yellow-600 border border-gray-200">
                                    {{ $item['no_antrian'] }}
                                </td>
                                <td class="border border-gray-200">
                                    <div class="font-bold text-gray-800">{{ $item['nama_lengkap'] }}</div>
                                    <div class="text-xs text-gray-400">{{ $item['jenis_kelamin'] }} - {{ $item['usia'] }}</div>
                                </td>
                                <td class="italic text-gray-500 max-w-xs truncate border border-gray-200">
                                    "{{ $item['keluhan'] }}"
                                </td>
                                <td class="text-center pr-4 border border-gray-200">
                                    <button @click="openInput({{ json_encode($item) }})"
                                        class="btn btn-sm bg-yellow-500 hover:bg-yellow-600 text-white border-none shadow-md shadow-yellow-200 rounded-lg">
                                        Input Vital
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- MODAL INPUT --}}
        <div x-show="openModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-modal="true">
            <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" @click="openModal = false"></div>
            <div class="flex min-h-full items-center justify-center p-4">
                <div class="relative bg-white w-full max-w-lg rounded-2xl shadow-2xl overflow-hidden">

                    <div class="bg-yellow-50 px-6 py-4 border-b border-yellow-100 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-yellow-800">Pemeriksaan Awal</h3>
                        <button @click="openModal = false" class="text-gray-400 hover:text-gray-600">✕</button>
                    </div>

                    <div class="p-6">
                        <div class="flex items-center justify-between mb-6 bg-gray-50 p-3 rounded-lg">
                            <div>
                                <p class="font-bold text-gray-800" x-text="selectedPasien?.nama_lengkap"></p>
                                <p class="text-xs text-gray-500">Silakan periksa tanda vital pasien.</p>
                            </div>
                            <div class="w-25 h-10 bg-yellow-200 rounded-md flex items-center justify-center font-bold text-yellow-700"
                                x-text="selectedPasien?.no_antrian"></div>
                        </div>

                        <form :action="'/staff/perawat/input-vital/' + selectedPasien.id" method="POST">
                            @csrf

                            <div class="grid grid-cols-3 gap-2">
                                <div class="form-control">
                                    <label
                                        class="label-text text-xs font-bold text-gray-500 mb-1 text-center block w-full">Berat
                                        Badan (Kg)</label>
                                    <input type="number" name="berat_badan"
                                        class="input border border-gray-300 rounded-lg pe-5" placeholder="Ex: 60" required>
                                </div>
                                <div class="form-control">
                                    <label
                                        class="label-text text-xs font-bold text-gray-500 mb-1 text-center block w-full">Tensi
                                        Darah (mmHg)</label>
                                    <input type="text" name="tensi_darah" class="input border border-gray-300 rounded-lg"
                                        placeholder="Ex: 120/80" required>
                                </div>
                                <div class="form-control">
                                    <label
                                        class="label-text text-xs font-bold text-gray-500 mb-1 text-center block w-full">Suhu
                                        Tubuh (°C)</label>
                                    <input type="number" step="0.1" name="suhu_badan"
                                        class="input border border-gray-300 rounded-lg pe-5" placeholder="Ex: 36.5"
                                        required>
                                </div>
                            </div>

                            <div class="form-control">
                                <label
                                    class="label-text text-xs font-bold text-gray-500 mb-1 text-center block w-full">Anamnesa
                                    / Detail Keluhan</label>
                                <textarea name="anamnesa" class="textarea h-24 w-full border border-gray-300 rounded-lg"
                                    placeholder="Tanyakan detail keluhan pasien..." required></textarea>
                            </div>

                            <div class="modal-action pt-2">
                                <button type="button" @click="openModal = false"
                                    class="btn bg-gray-500 hover:bg-gray-600 text-white border-none">Batal</button>
                                <button type="submit"
                                    class="btn bg-yellow-500 hover:bg-yellow-600 text-white border-none">Simpan & Lanjut ke
                                    Dokter</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection