@extends('layouts.sidebar')

@section('title', 'Kasir')

@section('content')
    @php
        $antrian = [
            [
                'id' => 1,
                'no_antrian' => 'A-001',
                'nama' => 'Andi Pratama',
                'diagnosa' => 'Hypertensi',
                'tagihan' => 'Rp 150.000',
                'detail_tagihan' => [
                    'Jasa Dokter' => 'Rp 100.000',
                    'Paracetamol (10)' => 'Rp 20.000',
                    'Amoxicillin (10)' => 'Rp 30.000',
                ],
            ],
        ];
    @endphp

    <div x-data="{
        openModal: false,
        selectedPasien: null,
        openBayar(item) {
            this.selectedPasien = item;
            this.openModal = true;
        }
    }">

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-[#2C3753]">Kasir</h1>
                    <p class="text-gray-500 text-sm">Pembayaran tagihan pasien.</p>
                </div>
                <div class="badge badge-success badge-outline font-bold text-green-700">Filter: Menunggu Pembayaran</div>
            </div>

            <div class="overflow-x-auto">
                <table class="table w-full">
                    <thead class="bg-green-50 text-green-800 uppercase text-xs font-bold">
                        <tr>
                            <th class="py-4 pl-4">Antrian</th>
                            <th>Pasien</th>
                            <th>Diagnosa</th>
                            <th>Total Tagihan</th>
                            <th class="text-right pr-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($antrian as $item)
                            <tr class="hover:bg-green-50/30 transition">
                                <td class="pl-4 font-mono font-bold text-lg text-green-600">{{ $item['no_antrian'] }}</td>
                                <td>
                                    <div class="font-bold text-gray-800">{{ $item['nama'] }}</div>
                                </td>
                                <td>
                                    <div class="badge badge-ghost">{{ $item['diagnosa'] }}</div>
                                </td>
                                <td class="font-bold text-gray-800">{{ $item['tagihan'] }}</td>
                                <td class="text-right pr-4">
                                    <button @click="openBayar({{ json_encode($item) }})"
                                        class="btn btn-sm bg-green-600 hover:bg-green-700 text-white border-none shadow-md shadow-green-200 rounded-lg">
                                        Proses Bayar
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- MODAL BAYAR --}}
        <div x-show="openModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-modal="true">
            <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" @click="openModal = false"></div>
            <div class="flex min-h-full items-center justify-center p-4">
                <div class="relative bg-white w-full max-w-md rounded-2xl shadow-2xl overflow-hidden">

                    <div class="bg-green-600 px-6 py-4 text-white text-center">
                        <h3 class="text-lg font-bold">Rincian Pembayaran</h3>
                        <p class="text-sm opacity-90" x-text="selectedPasien?.no_antrian + ' - ' + selectedPasien?.nama">
                        </p>
                    </div>

                    <div class="p-6">
                        {{-- Detail Tagihan (Simulasi Loop Object JS) --}}
                        <div class="space-y-2 mb-6 border-b border-gray-100 pb-4">
                            <template x-for="(harga, item) in selectedPasien?.detail_tagihan">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500" x-text="item"></span>
                                    <span class="font-semibold text-gray-800" x-text="harga"></span>
                                </div>
                            </template>
                        </div>

                        <div class="flex justify-between items-center mb-6 bg-green-50 p-3 rounded-lg">
                            <span class="font-bold text-green-800">TOTAL YANG HARUS DIBAYAR</span>
                            <span class="font-extrabold text-xl text-green-700" x-text="selectedPasien?.tagihan"></span>
                        </div>

                        <form action="#" method="POST">
                            @csrf
                            <div class="form-control mb-6">
                                <label class="label-text font-bold mb-1">Metode Pembayaran</label>
                                <select name="metode" class="select select-bordered w-full">
                                    <option value="cash">Tunai (Cash)</option>
                                    <option value="qris">QRIS / E-Wallet</option>
                                    <option value="transfer">Transfer Bank</option>
                                </select>
                            </div>

                            <button type="submit"
                                class="btn bg-green-600 hover:bg-green-700 text-white w-full border-none shadow-lg">
                                Konfirmasi Pembayaran Lunas
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
