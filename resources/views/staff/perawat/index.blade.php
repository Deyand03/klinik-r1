@extends('layouts.sidebar')

@section('title', 'Perawat - Tanda Vital')

@section('content')
    {{-- DUMMY DATA --}}
    @php
        $antrian = [
            [
                'id' => 1,
                'no_antrian' => 'A-001',
                'nama' => 'Andi Pratama',
                'keluhan' => 'Sakit kepala bagian belakang nyut-nyutan sejak semalam.',
                'jenis_kelamin' => 'Laki-laki',
                'usia' => '25 Thn',
            ],
        ];
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
                <div class="badge badge-warning badge-outline font-bold text-yellow-600">Filter: Menunggu Perawat</div>
            </div>

            <div class="overflow-x-auto">
                <table class="table w-full">
                    <thead class="bg-yellow-50 text-yellow-800 uppercase text-xs font-bold">
                        <tr>
                            <th class="py-4 pl-4">Antrian</th>
                            <th>Pasien</th>
                            <th>Keluhan Awal (Dari Web)</th>
                            <th class="text-right pr-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($antrian as $item)
                            <tr class="hover:bg-yellow-50/30 transition">
                                <td class="pl-4 font-mono font-bold text-lg text-yellow-600">{{ $item['no_antrian'] }}</td>
                                <td>
                                    <div class="font-bold text-gray-800">{{ $item['nama'] }}</div>
                                    <div class="text-xs text-gray-400">{{ $item['jenis_kelamin'] }} - {{ $item['usia'] }}
                                    </div>
                                </td>
                                <td class="italic text-gray-500 max-w-xs truncate">"{{ $item['keluhan'] }}"</td>
                                <td class="text-right pr-4">
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
                        <div class="flex items-center gap-3 mb-6 bg-gray-50 p-3 rounded-lg">
                            <div class="w-10 h-10 bg-yellow-200 rounded-full flex items-center justify-center font-bold text-yellow-700"
                                x-text="selectedPasien?.no_antrian"></div>
                            <div>
                                <p class="font-bold text-gray-800" x-text="selectedPasien?.nama"></p>
                                <p class="text-xs text-gray-500">Silakan periksa tanda vital pasien.</p>
                            </div>
                        </div>

                        <form action="#" method="POST" class="space-y-4"> @csrf
                            <div class="grid grid-cols-2 gap-4">
                                <div class="form-control">
                                    <label class="label-text text-xs font-bold text-gray-500 mb-1">Berat Badan (Kg)</label>
                                    <input type="number" name="berat_badan" class="input input-bordered w-full"
                                        placeholder="Ex: 60">
                                </div>
                                <div class="form-control">
                                    <label class="label-text text-xs font-bold text-gray-500 mb-1">Tensi Darah
                                        (mmHg)</label>
                                    <input type="text" name="tensi_darah" class="input input-bordered w-full"
                                        placeholder="Ex: 120/80">
                                </div>
                            </div>
                            <div class="form-control">
                                <label class="label-text text-xs font-bold text-gray-500 mb-1">Suhu Tubuh (°C)</label>
                                <input type="number" step="0.1" name="suhu_badan" class="input input-bordered w-full"
                                    placeholder="Ex: 36.5">
                            </div>
                            <div class="form-control">
                                <label class="label-text text-xs font-bold text-gray-500 mb-1">Anamnesa / Detail
                                    Keluhan</label>
                                <textarea name="anamnesa" class="textarea textarea-bordered w-full h-24"
                                    placeholder="Tanyakan detail keluhan pasien..."></textarea>
                            </div>

                            <div class="modal-action pt-4">
                                <button type="button" @click="openModal = false" class="btn btn-ghost">Batal</button>
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
