@extends('layouts.index')

@section('title', 'KlinikR1')

@section('content')
    <div class="bg-linear-to-b from-brand-tertiary to-[#2C3753] py-32 px-4 sm:px-6 lg:px-8">
        <div class="max-w-xl mx-auto">
            <form action="{{ route('cari_dokter') }}" method="GET">
                <div class="form-control w-full">
                    <label class="label"><span class="label-text text-white font-semibold">Filter Klinik</span></label>
                    {{-- onchange="this.form.submit()" membuat form otomatis kirim saat dipilih --}}
                    <select name="klinik" onchange="this.form.submit()"
                        class="select select-bordered w-full text-gray-700 bg-white">
                        <option value="">Semua Klinik</option>
                        @foreach ($clinics as $c)
                            <option value="{{ $c['id'] }}" {{ request('klinik') == $c['id'] ? 'selected' : '' }}>
                                {{ $c['nama'] }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>
    </div>

    <div class="bg-gray-50 py-12 px-4 sm:px-6 lg:px-8 -mt-8 rounded-t-3xl">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                @forelse($doctors as $doc)
                    <div
                        class="card card-side bg-white shadow-lg border border-gray-100 rounded-xl overflow-hidden flex flex-col sm:flex-row">
                        <figure class="sm:w-1/3 h-64 sm:h-auto relative">
                            <img src="{{ $doc['foto_profil'] ?? 'https://placehold.co/300x400/png?text=Dokter' }}" alt="{{ $doc['nama_lengkap'] }}"
                                class="h-full w-full object-cover" />
                        </figure>
                        <div class="card-body sm:w-2/3 p-6">
                            <div class="block sm:hidden mb-4">
                                <h2 class="text-xl font-bold text-[#2C3753]">{{ $doc['nama_lengkap'] }}</h2>
                                <hr class="border-gray-300 mt-2">
                            </div>
                            <div
                                class="hidden sm:block w-[calc(100%+24px)] border-b-2 border-l-2 border-[#2C3753] rounded-bl-4xl pl-5 mb-4 -mr-6 pr-6 -mt-6 pt-4 pb-4">
                                <h2 class="text-xl font-bold text-[#2C3753]">{{ $doc['nama_lengkap'] }}</h2>
                            </div>
                            <div class="space-y-2 mb-4 px-0 sm:px-2">
                                <p class="flex items-center text-[#2C3753] font-bold text-lg"><span
                                        class="font-bold mr-1">{{ $doc['klinik']['nama'] ?? '-' }}</p>
                                <p class="text-red-500 font-bold flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Tidak Ada Jadwal Praktik Hari Ini
                                </p>
                            </div>
                            <div class="card-actions justify-end mt-auto">
                                <a href="{{ route('profil_dokter', $doc['id']) }}"
                                    class="btn bg-brand-tertiary hover:bg-[#5b78eb] text-white border-none w-full sm:w-auto btn-sm h-10 px-6 rounded-md normal-case font-medium text-base">Profil
                                    & Jadwal Praktik</a>
                            </div>
                        </div>
                    </div>

                @empty
                    <div class="col-span-2 text-center py-10">
                        <p class="text-gray-500 text-lg">Tidak ada dokter yang ditemukan.</p>
                    </div>
                @endforelse

            </div>
        </div>
    </div>

    <div class="card lg:card-side bg-white w-full rounded-none border-none flex flex-col lg:flex-row">

        <figure class="lg:w-1/2 min-h-[250px] lg:min-h-[350px] relative m-0 p-0">
            <img src="https://placehold.co/800x600/e2e8f0/888888?text=Fasilitas+Rumah+Sakit" alt="Fasilitas RS"
                class="absolute inset-0 w-full h-full object-cover" />
        </figure>

        <div class="card-body lg:w-1/2 p-6 lg:p-12 justify-center">
            <h3 class="text-[#4cd6c0] font-bold text-lg md:text-xl uppercase tracking-wider mb-1">
                Fasilitas dan Layanan
            </h3>

            <h2 class="text-[#3b4c7a] font-bold text-xl md:text-2xl mb-3 leading-tight">
                Layanan Prima dengan Fasilitas Terlengkap dan Terintegrasi
            </h2>

            <p class="text-gray-600 mb-6 leading-relaxed text-base">
                Kami menyediakan berbagai fasilitas medis modern untuk menunjang kesehatan Anda, mulai dari ruang
                rawat inap yang nyaman hingga peralatan medis terkini.
            </p>

            <div class="card-actions">
                <a href="{{ route('pasien.fasilitas-layanan') }}"
                    class="btn btn-md bg-brand-secondary hover:bg-[#2f7e72] text-white border-none px-6 rounded-full normal-case text-base shadow-md">
                    Lebih Lanjut
                </a>
            </div>
        </div>

    </div>
    @vite('resources/js/utility/navbar_beranda.js')
@endsection
