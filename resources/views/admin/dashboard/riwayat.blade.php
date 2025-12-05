@extends('layouts.sidebar')
@section('title', 'Riwayat Kunjungan')
@section('content')

<div class="flex flex-col md:flex-row gap-4 mb-8 items-stretch">
    <div class="flex-1 bg-white text-brand-secondary px-6 py-4 rounded-xl shadow-md border-l-4 border-[#81E1DD] flex items-center">
        <div>
            <h2 class="text-xl font-bold tracking-wide">Riwayat Kunjungan & Antrian</h2>
            <p class="text-sm text-gray-500 mt-1">Pantau seluruh aktivitas kunjungan pasien, filter berdasarkan klinik atau dokter.</p>
        </div>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-8">

    {{-- HEADER & FILTERS --}}
    <div class="bg-linear-to-b from-brand-secondary to-[#81E1DD] px-6 py-4">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-2">
            <h3 class="text-white font-bold text-lg tracking-wide">Data Kunjungan</h3>
        </div>

        {{-- FORM FILTER KOMPLEKS --}}
        <form action="{{ route('admin.riwayat') }}" method="GET" class="flex flex-wrap gap-3 items-center w-full">
            
            {{-- 1. FILTER BULAN --}}
            <div class="relative min-w-[140px] flex-1 md:flex-none">
                <select name="month_table" onchange="this.form.submit()" 
                    class="w-full appearance-none py-2 pl-3 pr-8 rounded text-sm bg-white/20 text-white font-bold focus:outline-none focus:ring-0 border-none cursor-pointer">
                    <option value="" class="text-black bg-white" style="color: black;" {{ request('month_table') == '' ? 'selected' : '' }}>Semua Bulan</option>
                    @foreach(range(1, 12) as $m)
                        <option value="{{ $m }}" class="text-black bg-white" style="color: black;" {{ request('month_table') == $m ? 'selected' : '' }}>
                            Bulan: {{ DateTime::createFromFormat('!m', $m)->format('M') }}
                        </option>
                    @endforeach
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-white">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>
            </div>

            {{-- 2. FILTER KLINIK --}}
            <div class="relative min-w-[150px] flex-1 md:flex-none">
                <select name="klinik_id" onchange="this.form.submit()" 
                    class="w-full appearance-none py-2 pl-3 pr-8 rounded text-sm bg-white/20 text-white font-bold focus:outline-none focus:ring-0 border-none cursor-pointer">
                    <option value="" class="text-black bg-white" style="color: black;" {{ request('klinik_id') == '' ? 'selected' : '' }}>Semua Klinik</option>
                    @if(isset($data['options']['clinics']))
                        @foreach($data['options']['clinics'] as $klinik)
                            <option value="{{ $klinik['id'] }}" class="text-black bg-white" style="color: black;" {{ request('klinik_id') == $klinik['id'] ? 'selected' : '' }}>
                                {{ $klinik['nama'] }}
                            </option>
                        @endforeach
                    @endif
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-white">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>
            </div>

            {{-- 3. FILTER DOKTER --}}
            <div class="relative min-w-[150px] flex-1 md:flex-none">
                <select name="dokter_id" onchange="this.form.submit()" 
                    class="w-full appearance-none py-2 pl-3 pr-8 rounded text-sm bg-white/20 text-white font-bold focus:outline-none focus:ring-0 border-none cursor-pointer">
                    <option value="" class="text-black bg-white" style="color: black;" {{ request('dokter_id') == '' ? 'selected' : '' }}>Semua Dokter</option>
                    @if(isset($data['options']['doctors']))
                        @foreach($data['options']['doctors'] as $dokter)
                            <option value="{{ $dokter['id'] }}" class="text-black bg-white" style="color: black;" {{ request('dokter_id') == $dokter['id'] ? 'selected' : '' }}>
                                dr. {{ $dokter['nama'] }}
                            </option>
                        @endforeach
                    @endif
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-white">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>
            </div>

            {{-- 4. SEARCH --}}
            <div class="relative flex-grow md:w-64">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Pasien / No Antrian..."
                    class="w-full pl-4 pr-10 py-2 rounded text-sm bg-white text-gray-700 focus:outline-none focus:ring-2 focus:ring-teal-200 shadow-sm" />
                <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-brand-secondary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </button>
            </div>
        </form>
    </div>

    {{-- TABEL DATA --}}
    <div class="overflow-x-auto">
        <table class="table w-full">
            <thead class="bg-teal-50 text-teal-600 uppercase text-xs font-bold tracking-wider">
                <tr>
                    <th class="py-4 pl-6 text-left">Nama Pasien</th>
                    {{-- MODIFIKASI: Kolom Klinik & Dokter jadi Klinik saja --}}
                    <th class="text-left">Klinik Tujuan</th>
                    {{-- MODIFIKASI: Kolom Status diganti Dokter --}}
                    <th class="text-left">Dokter Pemeriksa</th>
                    <th class="text-left">Waktu Kunjungan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
            @forelse ($data['table_data'] as $item)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="pl-6 py-4">
                        <div class="flex items-center space-x-3">
                            <div class="avatar placeholder">
                                <div class="{{ $item['color'] }} rounded-full w-10 h-10 flex items-center justify-center font-bold text-sm shadow-sm">
                                    <span>{{ $item['initial'] }}</span>
                                </div>
                            </div>
                            <div>
                                <div class="font-bold text-gray-800">{{ $item['name'] }}</div>
                                <div class="text-xs text-gray-500 font-mono">{{ $item['no_antrian'] ?? '-' }}</div>
                            </div>
                        </div>
                    </td>
                    {{-- Kolom Klinik Saja --}}
                    <td class="text-gray-600 font-semibold text-sm">
                        {{ $item['klinik'] }}
                    </td>
                    {{-- Kolom Dokter (Menggantikan Status) --}}
                    <td class="text-gray-600 text-sm">
                        <div class="flex items-center gap-2">
                             {{-- Icon Dokter Kecil --}}
                             <svg class="w-4 h-4 text-brand-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                             <span class="font-medium">{{ $item['dokter'] }}</span>
                        </div>
                    </td>
                    <td class="text-gray-600 font-medium text-sm">
                        {{ \Carbon\Carbon::parse($item['registered_at'])->format('d M Y, H:i') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center py-8 text-gray-400">
                        Tidak ada riwayat kunjungan yang cocok dengan filter.
                        <br><span class="text-xs">Coba ganti filter Bulan ke "Semua Bulan".</span>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    {{-- PAGINATION --}}
    @if ($data['table_data']->hasPages())
    <div class="px-6 py-4 flex justify-center items-center border-t border-gray-100 bg-white">
        <div class="flex items-center gap-2 select-none">
            @if ($data['table_data']->onFirstPage())
                <span class="text-gray-400 cursor-not-allowed text-sm">Previous</span>
            @else
                <a href="{{ $data['table_data']->previousPageUrl() }}" class="text-brand-secondary hover:underline text-sm font-medium">Previous</a>
            @endif
            <div class="flex items-center mx-2 gap-1">
                @foreach ($data['table_data']->onEachSide(1)->links()->elements as $element)
                    @if (is_string($element)) <span class="px-2 text-gray-500 text-sm">{{ $element }}</span> @endif
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $data['table_data']->currentPage())
                                <span class="text-[#388e72] font-bold text-sm px-2 cursor-default">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="text-brand-secondary hover:underline hover:text-[#388e72] text-sm px-2">{{ $page }}</a>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </div>
            @if ($data['table_data']->hasMorePages())
                <a href="{{ $data['table_data']->nextPageUrl() }}" class="text-brand-secondary hover:underline text-sm font-medium">Next</a>
            @else
                <span class="text-gray-400 cursor-not-allowed text-sm">Next</span>
            @endif
        </div>
    </div>
    @endif
</div>
@endsection