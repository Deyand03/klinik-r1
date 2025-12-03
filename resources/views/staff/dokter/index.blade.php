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

    <div x-data="{
        openModal: false,
        selectedPasien: null,
        openPeriksa(item) {
            this.selectedPasien = item;
            this.openModal = true;
        }
    }">

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
                        @foreach ($antrian as $item)
                            <tr class="hover:bg-purple-50/30 transition">
                                <td class="pl-4 font-mono font-bold text-lg text-purple-600">{{ $item['no_antrian'] }}</td>
                                <td>
                                    <div class="font-bold text-gray-800">{{ $item['nama'] }}</div>
                                </td>
                                <td>
                                    <div class="text-sm font-medium">{{ $item['anamnesa'] }}</div>
                                    <div class="text-xs text-purple-600 bg-purple-100 px-2 py-0.5 rounded w-fit mt-1">
                                        {{ $item['vital'] }}</div>
                                </td>
                                <td class="text-right pr-4">
                                    <button @click="openPeriksa({{ json_encode($item) }})"
                                        class="btn btn-sm bg-purple-600 hover:bg-purple-700 text-white border-none shadow-md shadow-purple-200 rounded-lg">
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
        <div x-show="openModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-modal="true">
            <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" @click="openModal = false"></div>
            <div class="flex min-h-full items-center justify-center p-4">
                <div class="relative bg-white w-full max-w-2xl rounded-2xl shadow-2xl overflow-hidden">

                    <div class="bg-purple-600 px-6 py-4 flex justify-between items-center text-white">
                        <h3 class="text-lg font-bold">Pemeriksaan Medis</h3>
                        <button @click="openModal = false" class="hover:bg-white/20 p-1 rounded">✕</button>
                    </div>

                    <div class="p-6">
                        {{-- Review Data Perawat --}}
                        <div class="bg-gray-50 p-4 rounded-xl mb-6 text-sm border border-gray-100">
                            <p class="font-bold text-gray-500 uppercase text-xs mb-1">Data dari Perawat:</p>
                            <p class="mb-1"><span class="font-semibold">Anamnesa:</span> <span
                                    x-text="selectedPasien?.anamnesa"></span></p>
                            <p><span class="font-semibold">Vital Signs:</span> <span x-text="selectedPasien?.vital"></span>
                            </p>
                        </div>

                        <form action="#" method="POST" class="space-y-5">
                            @csrf
                            {{-- Diagnosa --}}
                            <div class="form-control">
                                <label class="label-text font-bold text-gray-700 mb-1">Diagnosa Dokter</label>
                                <input type="text" name="diagnosa" class="input input-bordered w-full"
                                    placeholder="Contoh: Hypertensi Grade 1..." required>
                            </div>

                            {{-- Resep Obat (Simple Selection) --}}
                            <div class="form-control">
                                <label class="label-text font-bold text-gray-700 mb-1">Resep Obat</label>
                                <div class="grid grid-cols-1 gap-2">
                                    {{-- Baris Obat 1 --}}
                                    <div class="flex gap-2">
                                        <select name="obat_id[]" class="select select-bordered w-full">
                                            <option value="">-- Pilih Obat --</option>
                                            <option value="1">Paracetamol 500mg (Stok: 100)</option>
                                            <option value="2">Amoxicillin 500mg (Stok: 50)</option>
                                        </select>
                                        <input type="number" name="jumlah[]" class="input input-bordered w-24"
                                            placeholder="Qty">
                                    </div>
                                    <p class="text-xs text-gray-400 italic">* Pilih obat dari stok apotek.</p>
                                </div>
                            </div>

                            {{-- Catatan --}}
                            <div class="form-control">
                                <label class="label-text font-bold text-gray-700 mb-1">Catatan / Saran</label>
                                <textarea name="catatan_dokter" class="textarea textarea-bordered h-20" placeholder="Istirahat cukup, kurangi garam..."></textarea>
                            </div>

                            <div class="modal-action pt-4 border-t border-gray-100">
                                <button type="button" @click="openModal = false" class="btn btn-ghost">Batal</button>
                                <button type="submit"
                                    class="btn bg-purple-600 hover:bg-purple-700 text-white border-none">Selesai & Ke
                                    Kasir</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
