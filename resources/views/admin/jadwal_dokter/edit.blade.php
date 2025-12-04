@extends('layouts.sidebar')

@section('title', 'Edit Jadwal Dokter')

@section('content')
<div class="container mx-auto max-w-5xl">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('admin.jadwal-dokter.index') }}" class="btn btn-circle btn-ghost text-gray-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
        </a>
        <h1 class="text-2xl font-bold text-brand-dark">Edit Jadwal Dokter</h1>
    </div>

    <div class="bg-white rounded-3xl shadow-lg border border-gray-100 overflow-hidden">
        <!-- Route Update pakai ID Staff -->
        <form action="{{ route('admin.jadwal-dokter.update', $staffId) }}" method="POST" class="p-8">
            @csrf
            @method('PUT')

            <div class="mb-8">
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Dokter</label>
                <div class="p-4 bg-gray-50 rounded-xl border border-gray-200 font-bold text-brand-dark">
                    {{ $dokterName }}
                </div>
            </div>

            <div class="divider text-xs text-gray-400 mb-6">EDIT JADWAL HARIAN</div>

            <div class="space-y-4">
                @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $day)
                    {{-- Cek apakah hari ini ada di data jadwal dokter --}}
                    @php
                        $dataHari = $currentSchedule[$day] ?? null;
                        $isActive = $dataHari ? true : false;
                    @endphp

                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-200 transition-colors hover:border-brand-secondary/30 {{ $isActive ? 'bg-white border-brand-secondary/50 shadow-sm' : '' }}">
                        <div class="flex flex-col md:flex-row gap-4 items-start md:items-center">

                            <!-- Checkbox Hari & Hidden Existing -->
                            <div class="flex items-center gap-3 w-32 shrink-0">
                                <!-- Hidden input Existing: 1 jika data ada di DB, 0 jika tidak -->
                                <input type="hidden" name="jadwal[{{ $day }}][existing]" value="{{ $isActive ? '1' : '0' }}">

                                <input type="checkbox"
                                       name="jadwal[{{ $day }}][aktif]"
                                       value="1"
                                       class="checkbox checkbox-secondary"
                                       {{ $isActive ? 'checked' : '' }} />

                                <span class="font-bold {{ $isActive ? 'text-brand-dark' : 'text-gray-500' }}">{{ $day }}</span>
                            </div>

                            <!-- Input Fields -->
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 flex-1 w-full">
                                <div>
                                    <label class="text-[10px] text-gray-400 font-bold uppercase block mb-1">Mulai</label>
                                    <input type="time" name="jadwal[{{ $day }}][jam_mulai]"
                                           value="{{ $dataHari['jam_mulai'] ?? '' }}"
                                           class="input input-sm input-bordered w-full bg-white">
                                </div>
                                <div>
                                    <label class="text-[10px] text-gray-400 font-bold uppercase block mb-1">Selesai</label>
                                    <input type="time" name="jadwal[{{ $day }}][jam_selesai]"
                                           value="{{ $dataHari['jam_selesai'] ?? '' }}"
                                           class="input input-sm input-bordered w-full bg-white">
                                </div>
                                <div>
                                    <label class="text-[10px] text-gray-400 font-bold uppercase block mb-1">Kuota</label>
                                    <input type="number" name="jadwal[{{ $day }}][kuota]"
                                           value="{{ $dataHari['kuota'] ?? 20 }}"
                                           class="input input-sm input-bordered w-full bg-white">
                                </div>
                                <div>
                                    <label class="text-[10px] text-gray-400 font-bold uppercase block mb-1">Status</label>
                                    <select name="jadwal[{{ $day }}][status]" class="select select-sm select-bordered w-full bg-white">
                                        <option value="Aktif" {{ ($dataHari['status'] ?? '') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                        <option value="Nonaktif" {{ ($dataHari['status'] ?? '') == 'Nonaktif' ? 'selected' : '' }}>Non-Aktif</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8 flex justify-end gap-3 border-t border-gray-100 pt-6">
                <a href="{{ route('admin.jadwal-dokter.index') }}" class="btn btn-ghost text-gray-500 rounded-xl">Batal</a>
                <button type="submit" class="btn bg-brand-secondary hover:bg-brand-secondary/90 text-white border-none px-8 rounded-xl shadow-lg">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection
