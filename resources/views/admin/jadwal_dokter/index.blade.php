@extends('layouts.sidebar')

@section('title', 'Manajemen Jadwal Dokter')

@section('content')
    <div class="container mx-auto px-4">
        <!-- ALERT MESSAGES -->
        @if (session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg flex items-start gap-3">
                <div class="text-green-500"><svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg></div>
                <div><h3 class="text-sm font-bold text-green-800">Berhasil</h3><p class="text-sm text-green-600">{{ session('success') }}</p></div>
            </div>
        @endif

        <!-- HEADER -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
            <div>
                <h1 class="text-2xl font-bold text-brand-dark">Jadwal Praktek Dokter</h1>
                <p class="text-gray-500 text-sm mt-1">Kelola hari, jam kerja, dan kuota per hari (Semua Klinik).</p>
            </div>
            <a href="{{ route('admin.jadwal-dokter.create') }}" class="btn bg-brand-secondary hover:bg-brand-secondary/90 text-white border-none gap-2 shadow-lg rounded-xl px-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                Tambah Jadwal
            </a>
        </div>

        <!-- FILTER BAR -->
        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 mb-8">
            <form method="GET" action="{{ route('admin.jadwal-dokter.index') }}" class="flex flex-col md:flex-row gap-4 items-end">

                <!-- FILTER KLINIK (BARU) -->
                <div class="form-control w-full md:w-64">
                    <label class="label pb-1"><span class="label-text font-bold text-gray-500 text-xs uppercase tracking-wider">Pilih Klinik</span></label>
                    <select name="clinic_id" class="select select-bordered bg-gray-50 rounded-xl w-full">
                        <option value="all">Semua Klinik</option>
                        @foreach ($clinics as $clinic)
                            <option value="{{ $clinic['id'] }}" {{ request('clinic_id') == $clinic['id'] ? 'selected' : '' }}>
                                {{ $clinic['nama'] }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-control w-full md:flex-1">
                    <label class="label pb-1"><span class="label-text font-bold text-gray-500 text-xs uppercase tracking-wider">Cari Dokter</span></label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik nama dokter..." class="input input-bordered w-full bg-gray-50 rounded-xl" />
                </div>

                <div class="form-control w-full md:w-48">
                    <label class="label pb-1"><span class="label-text font-bold text-gray-500 text-xs uppercase tracking-wider">Hari</span></label>
                    <select name="hari" class="select select-bordered bg-gray-50 rounded-xl w-full">
                        <option value="">Semua Hari</option>
                        @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $h)
                            <option value="{{ $h }}" {{ request('hari') == $h ? 'selected' : '' }}>{{ $h }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn bg-brand-secondary text-white rounded-xl">Filter</button>
                <a href="{{ route('admin.jadwal-dokter.index') }}" class="btn btn-outline border-gray-200 text-gray-600 hover:bg-gray-100 rounded-xl">Reset</a>
            </form>
        </div>

        <!-- GRID JADWAL -->
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            @forelse ($schedules as $item)
                <div class="flex flex-col justify-between gap-2 bg-white shadow-sm rounded-2xl px-6 py-5 border border-gray-100 border-l-[6px] border-l-brand-secondary transition-all hover:shadow-xl group">
                    <div>
                        <div class="flex justify-between items-start pl-2">
                            <div class="flex items-center gap-4">
                                <div class="avatar online">
                                    <div class="w-14 h-14 rounded-2xl ring-2 ring-offset-2 ring-brand-secondary/30">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($item['dokter']) }}&background=random&bold=true" />
                                    </div>
                                </div>
                                <div class="flex flex-col">
                                    <h3 class="font-bold text-lg text-brand-dark group-hover:text-brand-btn transition">{{ $item['dokter'] }}</h3>
                                    <h4 class="text-xs text-gray-500 font-medium uppercase tracking-wide">{{ $item['spesialis'] }}</h4>
                                    <!-- Badge Nama Klinik -->
                                    <span class="inline-block mt-1 px-2 py-0.5 rounded text-[10px] font-bold bg-gray-100 text-gray-500 w-fit">
                                        {{ $item['klinik'] }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 border border-gray-100 px-4 py-4 mt-5 rounded-xl space-y-3">
                            <div class="flex justify-between items-start">
                                <div class="text-[10px] text-gray-400 uppercase tracking-wider font-bold mt-1">Hari Praktek</div>
                                <div class="flex flex-wrap justify-end gap-1.5 max-w-[70%]">
                                    @foreach ($item['hari'] as $h)
                                        @php
                                            $isDayActive = isset($item['details'][$h]) && $item['details'][$h]['status'] == 'Aktif';
                                        @endphp
                                        <span class="px-2 py-1 rounded-md text-[10px] font-bold border {{ $isDayActive ? 'bg-white border-brand-secondary/30 text-brand-secondary' : 'bg-gray-100 border-gray-200 text-gray-400' }}">
                                            {{ substr($h, 0, 3) }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="pl-1 pt-5">
                            <div class="flex justify-between text-xs mb-1.5">
                                <span class="text-gray-500">Terisi Hari Ini</span>
                                <span class="font-bold {{ $item['terisi'] >= $item['kuota'] ? 'text-red-500' : 'text-brand-secondary' }}">
                                    {{ $item['terisi'] }} <span class="text-gray-400 font-normal">/ {{ $item['kuota'] }}</span>
                                </span>
                            </div>
                            <progress class="progress w-full h-2 {{ $item['terisi'] >= $item['kuota'] ? 'progress-error' : 'progress-secondary' }}" value="{{ $item['terisi'] }}" max="{{ $item['kuota'] }}"></progress>
                        </div>
                    </div>

                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <a href="{{ route('admin.jadwal-dokter.edit', $item['staff_id']) }}" class="btn btn-block btn-sm btn-outline border-gray-200 hover:bg-brand-primary hover:border-brand-primary hover:text-brand-dark normal-case font-bold rounded-xl transition-all">
                            Edit Jadwal
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12 bg-gray-50 rounded-2xl border-2 border-dashed border-gray-300">
                    <p class="text-gray-500 font-medium">Belum ada jadwal dokter yang sesuai filter.</p>
                    <a href="{{ route('admin.jadwal-dokter.create') }}" class="text-brand-secondary hover:underline text-sm font-bold mt-2">Buat baru</a>
                </div>
            @endforelse
        </div>
    </div>
@endsection
