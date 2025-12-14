@extends('layouts.index')
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />

@section('title', 'Riwayat Reservasi - KlinikR1')

@section('content')
    {{-- TAMBAHKAN CODE INI DI DIV PEMBUNGKUS --}}
    <div x-data="{
        ticketModalOpen: false,
        activeTicket: null,
        userNama: '{{ session('user_data')['pasien']['nama_lengkap'] ?? 'Pasien' }}',
    
        openTicket(item) {
            this.activeTicket = item;
            this.ticketModalOpen = true;
        },
    
        formatDate(dateString) {
            const options = { day: 'numeric', month: 'long', year: 'numeric' };
            return new Date(dateString).toLocaleDateString('id-ID', options);
        }
    }">

        {{-- 1. HERO SECTION (Mirip Cari Dokter) --}}
        {{-- Menggunakan gradient dan style text yang konsisten --}}
        <div class="bg-linear-to-b from-brand-tertiary to-[#2C3753] py-32 px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto text-center">
                <h1 class="text-4xl font-bold text-white mb-2">
                    Riwayat <span class="text-[#4cd6c0]">Reservasi</span>
                </h1>
                <p class="text-gray-200 mb-10 text-lg">
                    Catatan kunjungan, rekam medis, dan dokumen penting Anda tersimpan aman di sini.
                </p>
            </div>
        </div>

        {{-- 2. MAIN CONTENT CONTAINER (Overlapping effect) --}}
        <div class="bg-gray-50 py-12 px-4 sm:px-6 lg:px-8 -mt-12 rounded-t-3xl min-h-screen">
            <div class="max-w-7xl mx-auto">

                {{-- Card Putih Pembungkus Tabel --}}
                <div class="bg-white shadow-xl rounded-xl overflow-hidden border border-gray-100">

                    {{-- Header Tools (Filter) --}}
                    <div class="p-6 border-b border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4">
                        <div class="flex items-center gap-2 text-[#2C3753]">
                            <span class="material-symbols-outlined text-2xl">history_edu</span>
                            <h2 class="text-xl font-bold">Daftar Kunjungan</h2>
                        </div>

                        {{-- Filter Dropdown (Styled) --}}
                        <div class="flex items-center gap-3">
                            <span class="text-gray-500 text-sm font-medium hidden md:block">Filter Klinik:</span>
                            <select
                                class="select select-bordered select-sm w-full md:w-48 bg-gray-50 border-gray-300 focus:border-[#4cd6c0] focus:ring-[#4cd6c0]">
                                <option selected>Semua Klinik</option>
                                <option>Klinik Umum</option>
                                <option>Klinik Gigi</option>
                                <option>Klinik Mata</option>
                            </select>
                        </div>
                    </div>

                    {{-- 3. TABEL DATA (Update Kolom) --}}
                    <div class="overflow-x-auto">
                        <table class="table w-full">
                            {{-- Head --}}
                            <thead class="bg-gray-50 text-gray-600 uppercase text-xs tracking-wider font-bold">
                                <tr>
                                    <th class="py-4 px-4 text-center">No. Antrian</th>
                                    <th class="py-4 px-4 text-left">Klinik</th>
                                    <th class="py-4 px-4 text-left">Nama Dokter</th>
                                    <th class="py-4 px-4 text-center">Tanggal Kunjungan</th>
                                    <th class="py-4 px-4 text-left w-1/5">Keluhan</th> {{-- w-1/5 agar kolom keluhan agak lebar --}}
                                    <th class="py-4 px-4 text-center">Status</th>
                                    <th class="py-4 px-4 text-center">No Tiket</th>
                                </tr>
                            </thead>

                            {{-- Body --}}
                            <tbody class="text-gray-700">
                                @forelse($riwayat as $item)
                                    <tr class="hover:bg-blue-50 transition-colors border-b border-gray-100">

                                        {{-- 1. No Antrian --}}
                                        <td class="py-4 px-4 text-center">
                                            <div class="font-mono font-bold text-lg text-[#2C3753]">
                                                {{ $item['no_antrian'] }}
                                            </div>
                                        </td>

                                        {{-- 2. Klinik --}}
                                        <td class="py-4 px-4">
                                            <div class="badge badge-outline text-gray-600 font-medium">
                                                {{ $item['klinik']['nama'] ?? 'Klinik Umum' }}
                                            </div>
                                        </td>

                                        {{-- 3. Nama Dokter --}}
                                        <td class="py-4 px-4">
                                            <div class="flex items-center gap-3">
                                                <div class="avatar placeholder">
                                                    {{-- PERBAIKAN: Tambahkan 'flex items-center justify-center' --}}
                                                    <div
                                                        class="bg-blue-100 text-blue-700 rounded-full w-8 h-8 flex items-center justify-center">
                                                        <span class="text-xs font-bold">
                                                            {{-- OPSI: Ambil inisial nama saja (skip gelar 'dr.') --}}
                                                            {{ substr(str_replace(['dr. ', 'Dr. '], '', $item['dokter']['nama_lengkap'] ?? 'Dr'), 0, 2) }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="font-bold text-[#2C3753]">
                                                    {{ $item['dokter']['nama_lengkap'] ?? '-' }}
                                                </div>
                                            </div>
                                        </td>

                                        {{-- 4. Tanggal Kunjungan --}}
                                        <td class="py-4 px-4 text-center text-sm font-medium">
                                            {{ \Carbon\Carbon::parse($item['tgl_kunjungan'])->translatedFormat('d M Y') }}
                                        </td>

                                        {{-- 5. Keluhan --}}
                                        <td class="py-4 px-4 text-sm text-gray-600 leading-snug">
                                            {{ Str::limit($item['keluhan'], 50) }}
                                        </td>

                                        {{-- 6. Status --}}
                                        <td class="py-4 px-4 text-center">
                                            @php
                                                $statusClass = match ($item['status']) {
                                                    'selesai' => 'badge-success text-white',
                                                    'batal' => 'badge-error text-white',
                                                    'menunggu_pembayaran' => 'badge-warning text-white',
                                                    'menunggu_dokter' => 'badge-info text-white',
                                                    'menunggu_perawat' => 'badge-info text-white',
                                                    'booking'
                                                        => 'badge-ghost text-gray-600', // Status 'booking' from seeder
                                                    default => 'badge-ghost text-gray-600',
                                                };
                                                $statusLabel = ucwords(str_replace('_', ' ', $item['status']));
                                            @endphp
                                            <div class="badge {{ $statusClass }} gap-1 text-xs py-3 px-3">
                                                {{ $statusLabel }}
                                            </div>
                                        </td>

                                        <td class="py-4 px-4 text-center">
                                            @if ($item['status'] !== 'batal')
                                                {{-- Tombol Pemicu Modal --}}
                                                <button @click="openTicket({{ json_encode($item) }})"
                                                    class="btn btn-sm bg-brand-secondary hover:bg-emerald-600 text-white border-none gap-1 shadow-md rounded-lg group">
                                                    <span
                                                        class="material-symbols-outlined text-[16px]">confirmation_number</span>
                                                    <span class="hidden md:inline">Lihat</span>
                                                </button>
                                            @else
                                                <span class="text-xs text-gray-400 italic">Dibatalkan</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    {{-- Empty State --}}
                                    <tr>
                                        <td colspan="7" class="text-center py-10">
                                            <div class="flex flex-col items-center justify-center text-gray-400">
                                                <span
                                                    class="material-symbols-outlined text-4xl mb-2">history_toggle_off</span>
                                                <p>Belum ada riwayat kunjungan.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination (Optional Look) --}}
                    <div class="p-4 border-t border-gray-100 flex justify-end">
                        <div class="btn-group">
                            <button class="btn btn-sm btn-ghost">«</button>
                            <button class="btn btn-sm bg-[#2C3753] text-white hover:bg-blue-900 border-none">1</button>
                            <button class="btn btn-sm btn-ghost">2</button>
                            <button class="btn btn-sm btn-ghost">»</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        {{-- MODAL TIKET (POPUP) --}}
        <div x-show="ticketModalOpen" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto">

            {{-- Backdrop Gelap --}}
            <div x-show="ticketModalOpen" x-transition.opacity class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm"
                @click="ticketModalOpen = false"></div>

            {{-- Konten Modal --}}
            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                <div x-show="ticketModalOpen" x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-sm">

                    <template x-if="activeTicket">
                        <div>
                            {{-- Header Tiket --}}
                            <div class="bg-brand-secondary p-6 text-center text-white relative">
                                <button @click="ticketModalOpen = false"
                                    class="absolute top-4 right-4 text-white/70 hover:text-white">✕</button>
                                <h2 class="text-xs font-semibold tracking-widest uppercase opacity-90">Nomor Antrian</h2>
                                <div class="mt-2 text-5xl font-extrabold font-mono" x-text="activeTicket.no_antrian"></div>
                                <div class="mt-2 badge badge-ghost bg-white/20 text-white border-none text-xs uppercase"
                                    x-text="activeTicket.status.replace('_', ' ')"></div>
                            </div>

                            {{-- Detail Tiket --}}
                            <div class="p-6 space-y-4 bg-white border-b border-gray-100">
                                <div>
                                    <p class="text-[10px] text-gray-400 uppercase font-bold">Pasien</p>
                                    <p class="text-brand-dark font-bold text-base" x-text="userNama"></p>
                                </div>
                                <div>
                                    <p class="text-[10px] text-gray-400 uppercase font-bold">Tanggal</p>
                                    <p class="text-brand-dark font-bold text-base"
                                        x-text="formatDate(activeTicket.tgl_kunjungan)"></p>
                                </div>
                                <div class="bg-gray-50 p-3 rounded-xl">
                                    <p class="text-[10px] text-gray-400 font-bold uppercase">Dokter</p>
                                    <p class="text-brand-dark font-bold text-sm" x-text="activeTicket.dokter.nama_lengkap">
                                    </p>
                                    <p class="text-xs text-brand-secondary font-semibold" x-text="activeTicket.klinik.nama">
                                    </p>
                                </div>
                            </div>

                            {{-- Footer Actions --}}
                            <div class="p-4 bg-gray-50 flex gap-2">

                                <button @click="ticketModalOpen = false"
                                    class="btn bg-brand-tertiary text-white btn-sm w-full border-none font-normal">Tutup</button>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>

    @vite('resources/js/utility/navbar_beranda.js')
@endsection
