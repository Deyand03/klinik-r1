@extends('layouts.sidebar')

@section('title', 'Tambah Jadwal Dokter')

@section('content')
<div class="container mx-auto px-4 max-w-3xl">

    <!-- ALERT MESSAGES -->
    @if (session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg flex items-start gap-3">
            <div class="text-green-500"><svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg></div>
            <div><h3 class="text-sm font-bold text-green-800">Berhasil</h3><p class="text-sm text-green-600">{{ session('success') }}</p></div>
        </div>
    @endif
    @if (session('error'))
        <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg flex items-start gap-3">
            <div class="text-red-500"><svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg></div>
            <div><h3 class="text-sm font-bold text-red-800">Gagal</h3><p class="text-sm text-red-600">{{ session('error') }}</p></div>
        </div>
    @endif

    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('admin.jadwal-dokter.index') }}" class="btn btn-circle btn-ghost text-gray-500 hover:bg-gray-100 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
        </a>
        <h1 class="text-2xl font-bold text-brand-dark">Buat Jadwal Baru</h1>
    </div>

    <div class="bg-white rounded-3xl shadow-lg border border-gray-100 overflow-hidden">

        <!-- BAGIAN 1: Filter Klinik (Reload Page method) -->
        <div class="p-8 border-b border-gray-100 bg-gray-50/50">
            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Langkah 1: Pilih Klinik</label>
            <form action="{{ route('admin.jadwal-dokter.create') }}" method="GET" class="flex gap-3">
                <select name="clinic_id" class="select select-bordered w-full bg-white rounded-xl" onchange="this.form.submit()">
                    <option disabled {{ request('clinic_id') ? '' : 'selected' }} value="">-- Pilih Klinik Dulu --</option>
                    @foreach($clinics as $clinic)
                        <option value="{{ $clinic['id'] }}" {{ (request('clinic_id') ?? $clinicId) == $clinic['id'] ? 'selected' : '' }}>
                            {{ $clinic['nama'] }}
                        </option>
                    @endforeach
                </select>
                <!-- Tombol ini optional kalau user gak ngeh onchange -->
                <button type="submit" class="btn bg-brand-primary text-brand-dark rounded-xl">Pilih</button>
            </form>
            @if(!request('clinic_id'))
                <p class="text-xs text-orange-500 mt-2 italic">* Silakan pilih klinik untuk melihat daftar dokter.</p>
            @endif
        </div>

        <!-- BAGIAN 2: Form Simpan Jadwal -->
        <form action="{{ route('admin.jadwal-dokter.store') }}" method="POST" class="p-8 {{ !request('clinic_id') ? 'opacity-50 pointer-events-none grayscale' : '' }}">
            @csrf

            <div class="mb-8">
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Langkah 2: Pilih Dokter</label>
                <select name="staff_id" class="select select-bordered w-full bg-white rounded-xl focus:border-brand-secondary focus:ring-2 focus:ring-brand-secondary/20 transition-all" required>
                    <option disabled selected value="">-- Pilih Dokter --</option>
                    @foreach($doctors as $doc)
                        <option value="{{ $doc['id'] }}" {{ old('staff_id') == $doc['id'] ? 'selected' : '' }}>
                            {{ $doc['nama_lengkap'] }}
                        </option>
                    @endforeach
                </select>
                @if(count($doctors) == 0 && request('clinic_id'))
                    <span class="text-red-500 text-xs mt-1">Tidak ada dokter di klinik ini.</span>
                @endif
                @error('staff_id')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="divider text-xs text-gray-400 mb-6 font-bold tracking-widest">ATUR JADWAL HARIAN</div>

            <div class="space-y-4">
                @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $day)
                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-200 hover:border-brand-secondary/30 transition-colors group">
                        <div class="flex flex-col md:flex-row gap-4 items-start md:items-center">
                            <div class="flex items-center gap-3 w-32 shrink-0">
                                <input type="checkbox" name="jadwal[{{ $day }}][aktif]" value="1"
                                    {{ old("jadwal.$day.aktif") ? 'checked' : '' }}
                                    class="checkbox checkbox-secondary" />
                                <span class="font-bold text-gray-700 group-hover:text-brand-secondary transition-colors">{{ $day }}</span>
                            </div>

                            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 flex-1 w-full">
                                <div>
                                    <label class="text-[10px] text-gray-400 font-bold uppercase block mb-1">Mulai</label>
                                    <input type="time" name="jadwal[{{ $day }}][jam_mulai]" value="{{ old("jadwal.$day.jam_mulai") }}" class="input input-sm input-bordered w-full bg-white focus:border-brand-secondary">
                                </div>
                                <div>
                                    <label class="text-[10px] text-gray-400 font-bold uppercase block mb-1">Selesai</label>
                                    <input type="time" name="jadwal[{{ $day }}][jam_selesai]" value="{{ old("jadwal.$day.jam_selesai") }}" class="input input-sm input-bordered w-full bg-white focus:border-brand-secondary">
                                </div>
                                <div>
                                    <label class="text-[10px] text-gray-400 font-bold uppercase block mb-1">Kuota</label>
                                    <input type="number" name="jadwal[{{ $day }}][kuota]" value="{{ old("jadwal.$day.kuota", 20) }}" class="input input-sm input-bordered w-full bg-white focus:border-brand-secondary">
                                </div>
                                <div>
                                    <label class="text-[10px] text-gray-400 font-bold uppercase block mb-1">Status</label>
                                    <select name="jadwal[{{ $day }}][status]" class="select select-sm select-bordered w-full bg-white focus:border-brand-secondary">
                                        <option value="Aktif" {{ old("jadwal.$day.status") == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                        <option value="Nonaktif" {{ old("jadwal.$day.status") == 'Nonaktif' ? 'selected' : '' }}>Non-Aktif</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8 flex justify-end gap-3 border-t border-gray-100 pt-6">
                <a href="{{ route('admin.jadwal-dokter.index') }}" class="btn btn-ghost text-gray-500 rounded-xl hover:bg-gray-100">Batal</a>
                <button type="submit" class="btn bg-brand-secondary hover:bg-brand-secondary/90 text-white border-none px-8 rounded-xl shadow-lg transform hover:-translate-y-0.5 transition-all">Simpan Jadwal</button>
            </div>
        </form>
    </div>
</div>
@endsection
