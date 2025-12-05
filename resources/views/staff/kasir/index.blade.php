@extends('layouts.sidebar')

@section('title', 'Kasir')

@section('content')
    <div x-data="{
        searchTerm: '',
        openModal: false,
        selectedPasien: null,
    
        // 1. Template URL (Placeholder: ID_ANTRIAN)
        // Hasil render server: http://.../staff/kasir/ID_ANTRIAN/bayar
        actionUrlTemplate: '{{ route('staff.kasir.store', 'id_antrian') }}',
    
        openBayar(item) {
            // Simulasi total tagihan (karena backend OperasionalController belum kirim data tagihan)
            // Nanti bisa dihapus jika backend sudah mengirim field 'total_tagihan'
            if (!item.total_biaya) item.total_biaya = 150000;
    
            this.selectedPasien = item;
            this.openModal = true;
        },
    
        // 2. Getter untuk membuat URL aksi form secara dinamis
        get formAction() {
            if (!this.selectedPasien) return '#';
            // Ganti tulisan 'ID_ANTRIAN' dengan ID asli (misal: 1)
            return this.actionUrlTemplate.replace('id_antrian', this.selectedPasien.id);
        }
    }">

        {{-- Header Page --}}
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
            <div>
                <h1 class="text-2xl font-bold text-brand-dark">Kasir & Pembayaran</h1>
                <p class="text-gray-500 text-sm mt-1">Kelola pembayaran dan konfirmasi tagihan pasien.</p>
            </div>
        </div>

        {{-- Filter / Search Bar --}}
        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 mb-8">
            <div class="flex flex-col md:flex-row gap-4 items-end">
                <div class="form-control w-full md:flex-1">
                    <label class="label pb-1">
                        <span class="label-text font-bold text-gray-500 text-xs uppercase tracking-wider">Cari Pasien</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                            <svg class="h-[1em] opacity-50 z-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none"
                                    stroke="currentColor">
                                    <circle cx="11" cy="11" r="8"></circle>
                                    <path d="m21 21-4.3-4.3"></path>
                                </g>
                            </svg>
                        </span>
                        <input type="text" x-model="searchTerm" placeholder="Ketik nama atau no antrian..."
                            class="input input-bordered w-full pl-10 bg-gray-50 focus:bg-white focus:border-brand-secondary rounded-xl transition-all" />
                    </div>
                </div>
                <button @click="searchTerm=''" type="button"
                    class="btn btn-outline border-gray-200 text-gray-600 hover:bg-gray-100 hover:border-gray-300 w-full md:w-auto rounded-xl">
                    Reset
                </button>
            </div>
        </div>

        {{-- Tabel Data --}}
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <div class="overflow-x-auto">
                <table class="table w-full text-center">
                    <thead class="bg-green-50 text-green-800 uppercase text-xs font-bold">
                        <tr>
                            <th class="py-4 pl-4">Antrian</th>
                            <th class="text-left">Pasien</th>
                            <th class="px-4">Diagnosa</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($antrian as $item)
                            {{-- Logic Filter Search di Client Side (AlpineJS) --}}
                            <tr class="hover:bg-green-50/30 transition"
                                x-show="searchTerm === '' || 
                                        '{{ strtolower($item['pasien']['nama_lengkap'] ?? '') }}'.includes(searchTerm.toLowerCase()) || 
                                        '{{ strtolower($item['no_antrian'] ?? '') }}'.includes(searchTerm.toLowerCase())">

                                <td class="pl-4 font-mono font-bold text-lg text-green-600">
                                    {{ $item['no_antrian'] }}
                                </td>
                                <td class="text-left">
                                    <div class="font-bold text-gray-800">
                                        {{-- 3. Perbaikan Akses Data Relasi Pasien --}}
                                        {{ $item['pasien']['nama_lengkap'] ?? 'Tanpa Nama' }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        NIK: {{ $item['pasien']['nik'] ?? '-' }}
                                    </div>
                                </td>
                                <td>
                                    <div class="badge badge-ghost">
                                        {{ Str::limit($item['keluhan'] ?? 'Belum ada diagnosa', 90) }}
                                    </div>
                                </td>
                                <td>
                                    <span class="badge badge-warning badge-outline font-bold text-xs">
                                        {{ $item['status'] == 'menunggu_pembayaran' ? 'Menunggu Pembayaran' : $item['status'] }}
                                    </span>
                                </td>
                                <td class="text-center pr-4">
                                    {{-- Kirim JSON data baris ini ke fungsi openBayar --}}
                                    <button @click="openBayar({{ json_encode($item) }})"
                                        class="btn btn-sm bg-green-600 hover:bg-green-700 text-white border-none shadow-md shadow-green-200 rounded-lg">
                                        Proses Pembayaran
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-8 text-gray-400">
                                    Tidak ada antrian pembayaran saat ini.
                                </td>
                            </tr>
                        @endforelse
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
                        <p class="text-sm opacity-90">
                            {{-- 4. Akses Data Nested di AlpineJS (selectedPasien.pasien.nama_lengkap) --}}
                            <span x-text="selectedPasien?.no_antrian"></span> -
                            <span x-text="selectedPasien?.pasien?.nama_lengkap"></span>
                        </p>
                    </div>

                    <div class="p-6">
                        <div class="space-y-2 mb-6 border-b border-gray-100 pb-4">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Jasa Pelayanan</span>
                                <span class="font-semibold text-gray-800">Rp 150.000</span>
                            </div>
                        </div>

                        <div class="flex justify-between items-center mb-6 bg-green-50 p-3 rounded-lg">
                            <span class="font-bold text-green-800">TOTAL TAGIHAN</span>
                            {{-- Tampilkan total biaya dari data selectedPasien --}}
                            <span class="font-extrabold text-xl text-green-700"
                                x-text="'Rp ' + (selectedPasien?.total_biaya || 0).toLocaleString('id-ID')"></span>
                        </div>

                        {{-- 5. Form Action Dinamis (:action) --}}
                        <form :action="formAction" method="POST">
                            @csrf

                            {{-- 6. Input Hidden Wajib untuk Controller --}}
                            {{-- Controller butuh 'total_biaya', kita ambil dari object JS --}}
                            <input type="hidden" name="total_biaya" :value="selectedPasien?.total_biaya">

                            <div class="form-control mb-6">
                                <label class="label-text font-bold mb-1">Metode Pembayaran</label>
                                {{-- Pastikan name="metode" sesuai validasi controller --}}
                                <select name="metode" class="select select-bordered bg-white w-full">
                                    <option value="cash">Tunai (Cash)</option>
                                    <option value="qris">QRIS / E-Wallet</option>
                                    <option value="transfer">Transfer Bank</option>
                                </select>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <button type="button" @click="openModal = false"
                                        class="btn bg-gray-200 hover:bg-gray-300 text-gray-800 w-full border-none shadow-lg">
                                        Batal
                                    </button>
                                </div>
                                <div>
                                    <button type="submit"
                                        class="btn bg-green-600 hover:bg-green-700 text-white w-full border-none shadow-lg">
                                        Konfirmasi Bayar
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
