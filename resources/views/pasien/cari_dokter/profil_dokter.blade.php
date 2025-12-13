@extends('layouts.index')

@section('title', 'Profil Dokter')

@section('content')

    @if (session('error'))
        {{-- Tambahkan x-data, x-init, x-show, dan x-transition --}}
        <div x-data="{ show: true }" 
             x-init="setTimeout(() => show = false, 5000)" 
             x-show="show"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-90"
             class="fixed top-20 right-4 z-50 animate-bounce">
            
            <div class="alert alert-error shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6 text-white" fill="none"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-white font-bold">{{ session('error') }}</span>
            </div>
        </div>
    @endif

    {{-- WRAPPER UTAMA ALPINE.JS --}}
    <div x-data="{
        bookingModalOpen: false,
        selectedDay: '',
        selectedShiftLabel: '',
        selectedDate: '',
    
        openBooking(day, shiftLabel, date) {
            this.selectedDay = day;
            this.selectedShiftLabel = shiftLabel;
            this.selectedDate = date;
            this.bookingModalOpen = true;
        }
    }">

        {{-- BAGIAN 1: HEADER PROFIL --}}
        <div class="bg-linear-to-b from-brand-tertiary to-[#2C3753] pt-28 pb-20 px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto">
                <div class="mb-6 md:mb-8">
                    <a href="{{ route('cari_dokter') }}"
                        class="inline-flex items-center text-white hover:text-gray-200 transition-colors font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali
                    </a>
                </div>
                <div class="grid grid-cols-[110px_1fr] md:flex md:flex-row gap-4 md:gap-12 items-start">

                    {{-- FOTO PROFIL DINAMIS --}}
                    <div class="col-span-1 md:w-1/3 lg:w-1/4 shrink-0">
                        <div
                            class="aspect-3/4 relative rounded-2xl overflow-hidden shadow-2xl border-2 md:border-4 border-white/20">
                            @php
                                $foto = $doctor['foto_profil'] ?? null;
                                $imgSrc =
                                    'https://placehold.co/600x800/2C3753/FFFFFF/png?text=' .
                                    urlencode($doctor['nama_lengkap']);

                                if ($foto) {
                                    // Jika link external (placeholder/https), pakai langsung
                                    if (Str::startsWith($foto, 'http')) {
                                        $imgSrc = $foto;
                                    }
                                    // Jika path lokal storage, tambahkan domain backend
                                    else {
                                        $imgSrc = 'http://localhost:8000/storage/' . $foto;
                                    }
                                }
                            @endphp

                            <img src="{{ $imgSrc }}" alt="{{ $doctor['nama_lengkap'] }}"
                                class="object-cover w-full h-full"
                                onerror="this.onerror=null; this.src='https://placehold.co/600x800/2C3753/FFFFFF/png?text=No+Image';" />
                        </div>
                    </div>

                    <div class="contents md:flex md:flex-col md:w-2/3 lg:w-3/4 md:justify-center">
                        <div class="col-span-1 text-white self-center md:self-start mb-0 md:mb-8">

                            {{-- NAMA & KLINIK DINAMIS --}}
                            <h1 class="text-xl sm:text-2xl md:text-5xl font-bold mb-1 md:mb-3 leading-tight">
                                {{ $doctor['nama_lengkap'] }}
                            </h1>
                            <div class="flex flex-wrap items-center gap-2">
                                <p
                                    class="text-sm sm:text-base md:text-xl opacity-90 font-medium badge badge-outline text-white md:border-none md:p-0">
                                    {{ $doctor['klinik']['nama'] ?? 'Umum' }}
                                </p>
                                <p class="text-sm sm:text-base md:text-xl opacity-75 font-light hidden md:inline">|</p>
                                <p class="text-sm sm:text-base md:text-xl opacity-90 font-medium text-brand-primary">
                                    {{ $doctor['spesialisasi'] ?? '-' }}
                                </p>
                            </div>

                        </div>

                        {{-- TENTANG DOKTER DINAMIS --}}
                        <div class="col-span-2 bg-white rounded-2xl p-6 md:p-8 shadow-xl text-gray-700 mt-4 md:mt-0">
                            <h3 class="text-[#2C3753] font-bold text-lg md:text-2xl mb-2 md:mb-4">Tentang Dokter</h3>
                            <p class="leading-relaxed text-sm md:text-lg text-gray-600">
                                {{-- Ambil dari DB atau Default text --}}
                                {{ $doctor['tentang'] ?? 'Belum ada informasi detail mengenai dokter ini.' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- BAGIAN 2: JADWAL PRAKTIK & PENGALAMAN --}}
        <div class="bg-white py-12 md:py-16 px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">

                    <div class="w-full">
                        <h3 class="text-[#2C3753] font-bold text-xl md:hidden mb-4">Jadwal Praktik</h3>

                        {{-- INFO BOX --}}
                        <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-4 rounded-r-lg">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-blue-700">
                                        <span class="font-bold">Perhatian:</span> Anda hanya dapat melakukan booking untuk jadwal praktik <span class="font-semibold text-blue-900">hari ini dan besok</span>. Silakan pilih jadwal yang tersedia untuk mendapatkan nomor antrian online.
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- LOGIC PHP UNTUK TANGGAL (HARI INI/BESOK) --}}
                        @php
                            \Carbon\Carbon::setLocale('id');
                            $today = \Carbon\Carbon::now()->translatedFormat('l');
                            $tomorrow = \Carbon\Carbon::tomorrow()->translatedFormat('l');
                        @endphp

                        <div class="overflow-x-auto rounded-xl shadow-lg border border-gray-200">
                            <table class="table w-full min-w-[500px]">
                                <thead class="bg-brand-tertiary text-white text-base">
                                    <tr>
                                        <th class="py-4 pl-6 text-left w-1/3">Hari</th>
                                        <th class="py-4 text-center w-1/3">Jam Praktik</th>
                                        <th class="py-4 pr-6 text-center w-1/3">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-700 font-medium text-base bg-white">
                                    @forelse($doctor['jadwal'] as $jadwal)
                                        @php
                                            $isAvailable = $jadwal['hari'] === $today || $jadwal['hari'] === $tomorrow;

                                            $bookingDate = '';
                                            if ($jadwal['hari'] === $today) {
                                                $bookingDate = date('Y-m-d');
                                            } elseif ($jadwal['hari'] === $tomorrow) {
                                                $bookingDate = date('Y-m-d', strtotime('+1 day'));
                                            }
                                        @endphp

                                        <tr
                                            class="hover:bg-green-50/50 border-b border-gray-100 align-middle transition-colors">
                                            <td class="py-5 pl-6 text-left">
                                                <span
                                                    class="block font-bold text-brand-secondary text-lg">{{ $jadwal['hari'] }}</span>
                                                @if ($jadwal['hari'] === $today)
                                                    <span class="badge badge-sm badge-accent text-white mt-1">Hari
                                                        Ini</span>
                                                @elseif($jadwal['hari'] === $tomorrow)
                                                    <span class="badge badge-sm badge-info text-white mt-1">Besok</span>
                                                @endif
                                            </td>
                                            <td class="py-5 text-center">
                                                <div class="flex flex-col items-center">
                                                    <span class="font-mono text-lg font-bold text-[#2C3753]">
                                                        {{ substr($jadwal['jam_mulai'], 0, 5) }} -
                                                        {{ substr($jadwal['jam_selesai'], 0, 5) }}
                                                    </span>

                                                    {{-- SISA KUOTA --}}
                                                    <div class="mt-1 flex flex-col items-center">
                                                        <span
                                                            class="text-xs font-bold uppercase tracking-wider text-gray-400">Sisa
                                                            Kuota</span>
                                                        @if (($jadwal['sisa_kuota'] ?? 0) > 0)
                                                            <span class="badge badge-sm badge-success text-white font-bold">
                                                                {{ $jadwal['sisa_kuota'] ?? $jadwal['kuota_harian'] }} /
                                                                {{ $jadwal['kuota_harian'] }}
                                                            </span>
                                                        @else
                                                            <span
                                                                class="badge badge-sm badge-error text-white font-bold">PENUH</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-5 pr-6 text-center">
                                                @if ($isAvailable && ($jadwal['sisa_kuota'] ?? 1) > 0)
                                                    <button
                                                        @click="openBooking('{{ $jadwal['hari'] }}', '{{ substr($jadwal['jam_mulai'], 0, 5) }} - {{ substr($jadwal['jam_selesai'], 0, 5) }}', '{{ $bookingDate }}')"
                                                        class="btn bg-brand-secondary hover:bg-emerald-600 text-white border-none shadow-md w-full px-6 rounded-xl">
                                                        Ambil Antrian
                                                    </button>
                                                @else
                                                    <button disabled
                                                        class="btn btn-disabled bg-gray-200 text-gray-400 border-none w-full px-6 rounded-xl cursor-not-allowed opacity-70">
                                                        @if (($jadwal['sisa_kuota'] ?? 1) <= 0 && $isAvailable)
                                                            Penuh
                                                        @else
                                                            Tidak Tersedia
                                                        @endif
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center py-4">Belum ada jadwal praktik.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- SIDEBAR: PENGALAMAN DINAMIS --}}
                    <div class="card bg-white shadow-lg border border-gray-200 rounded-xl p-6 lg:p-10 h-full">
                        <h3 class="text-[#2C3753] font-bold text-xl md:text-2xl mb-6">Pengalaman Bekerja</h3>

                        <ul class="list-disc list-inside space-y-4 text-gray-600 font-medium text-lg">
                            @if (!empty($doctor['pengalaman']))
                                {{-- Pecah string berdasarkan koma (,) dan loop --}}
                                @foreach (explode(',', $doctor['pengalaman']) as $exp)
                                    <li class="pl-2">{{ trim($exp) }}</li>
                                @endforeach
                            @else
                                <li class="pl-2 italic text-gray-400">Belum ada data pengalaman.</li>
                            @endif
                        </ul>
                    </div>

                </div>
            </div>
        </div>

        {{-- BAGIAN FASILITAS (Static) --}}
        <div class="card lg:card-side bg-white w-full rounded-none border-none flex flex-col lg:flex-row">
            <figure class="lg:w-1/2 min-h-[250px] lg:min-h-[350px] relative m-0 p-0">
                <img src="https://placehold.co/800x600/e2e8f0/888888?text=Fasilitas+Rumah+Sakit" alt="Fasilitas RS"
                    class="absolute inset-0 w-full h-full object-cover" />
            </figure>
            <div class="card-body lg:w-1/2 p-6 lg:p-12 justify-center">
                <h3 class="text-brand-secondary font-bold text-lg md:text-xl uppercase tracking-wider mb-1">Fasilitas dan
                    Layanan</h3>
                <h2 class="text-[#3b4c7a] font-bold text-xl md:text-2xl mb-3 leading-tight">Layanan Prima dengan Fasilitas
                    Terlengkap</h2>
                <p class="text-gray-600 mb-6 leading-relaxed text-base">Kami menyediakan berbagai fasilitas medis modern
                    untuk menunjang kesehatan Anda.</p>
                <div class="card-actions">
                    <a href="{{ route('pasien.fasilitas-layanan') }}"
                        class="btn btn-md bg-brand-secondary hover:bg-[#2f7e72] text-white border-none px-6 rounded-full normal-case text-base shadow-md">Lebih
                        Lanjut</a>
                </div>
            </div>
        </div>

        {{-- MODAL BOOKING (Sudah Updated) --}}
        <div x-show="bookingModalOpen" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto"
            aria-labelledby="modal-title" role="dialog" aria-modal="true">

            <div x-show="bookingModalOpen" x-transition.opacity
                class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity"
                @click="bookingModalOpen = false">
            </div>

            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                <div x-show="bookingModalOpen" x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-md border border-gray-100">

                    {{-- Header Modal --}}
                    <div class="bg-brand-tertiary px-6 py-4 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-white flex items-center gap-2">Konfirmasi Booking</h3>
                        <button @click="bookingModalOpen = false"
                            class="text-white/70 hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="px-6 py-6">
                        <form action="{{ route('booking.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id_dokter" value="{{ $doctor['id'] }}">

                            {{-- Review Dokter --}}
                            <div class="bg-gray-50 rounded-xl p-4 border border-gray-100 mb-6 flex gap-4 items-center">
                                <div class="avatar placeholder">
                                    <div class="bg-brand-secondary text-white rounded-full w-12">
                                        <span class="text-lg font-bold">{{ substr($doctor['nama_lengkap'], 0, 1) }}</span>
                                    </div>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 font-bold uppercase tracking-wider">Dokter Pilihan</p>
                                    <h4 class="font-bold text-[#2C3753]">{{ $doctor['nama_lengkap'] }}</h4>
                                    <p class="text-sm text-gray-600 mt-0.5">
                                        Jadwal: <span x-text="selectedDay"
                                            class="font-semibold text-brand-secondary"></span> • <span
                                            x-text="selectedShiftLabel"></span>
                                    </p>
                                </div>
                            </div>

                            {{-- INPUT TANGGAL (READONLY) --}}
                            <div class="mb-5 text-left">
                                <label class="block text-sm font-bold text-gray-700 mb-2">
                                    Tanggal Kunjungan
                                </label>
                                <input type="date" name="tanggal" required readonly x-model="selectedDate"
                                    class="input input-bordered w-full rounded-xl bg-gray-100 text-gray-500 cursor-not-allowed focus:border-brand-secondary focus:ring-brand-secondary">
                                <p class="text-xs text-gray-400 mt-1.5 ml-1">* Tanggal otomatis terpilih sesuai jadwal.</p>
                            </div>

                            {{-- INPUT KELUHAN --}}
                            <div class="mb-5 text-left">
                                <label class="block text-sm font-bold text-gray-700 mb-2">
                                    Keluhan / Gejala Awal <span class="text-red-500">*</span>
                                </label>
                                <textarea name="keluhan" rows="3" required
                                    class="textarea textarea-bordered w-full rounded-xl bg-white text-gray-700 focus:border-brand-secondary focus:ring-brand-secondary text-base leading-relaxed"
                                    placeholder="Contoh: Sakit gigi..."></textarea>
                            </div>

                            {{-- TOMBOL SUBMIT --}}
                            <div class="flex flex-col-reverse sm:flex-row gap-3 sm:justify-end">
                                <button type="button" @click="bookingModalOpen = false"
                                    class="btn btn-ghost text-gray-500 rounded-xl">Batal</button>
                                <button type="submit"
                                    class="btn bg-brand-secondary hover:bg-emerald-600 text-white border-none rounded-xl px-6 shadow-lg">
                                    Konfirmasi Booking
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

    @vite('resources/js/utility/navbar_beranda.js')
@endsection
