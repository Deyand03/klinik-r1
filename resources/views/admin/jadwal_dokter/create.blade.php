@extends('layouts.sidebar')

@section('title', 'Tambah Jadwal Dokter')

@section('content')
<div class="container mx-auto max-w-5xl">
    @if (session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg flex items-start gap-3 shadow-sm animate-pulse">
            <div class="text-green-500"><svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg></div>
            <div>
                <h3 class="text-sm font-bold text-green-800">Berhasil</h3>
                <p class="text-sm text-green-600">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg flex items-start gap-3 shadow-sm animate-pulse">
            <div class="text-red-500"><svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg></div>
            <div>
                <h3 class="text-sm font-bold text-red-800">Gagal</h3>
                <p class="text-sm text-red-600">{{ session('error') }}</p>
            </div>
        </div>
    @endif
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('admin.jadwal-dokter.index') }}" class="btn btn-circle btn-ghost text-gray-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
        </a>
        <h1 class="text-2xl font-bold text-brand-dark">Buat Jadwal Baru</h1>
    </div>

    <div class="bg-white rounded-3xl shadow-lg border border-gray-100 overflow-hidden">
        <form action="{{ route('admin.jadwal-dokter.store') }}" method="POST" class="p-8">
            @csrf

            <div class="mb-8">
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Pilih Dokter</label>
                <select name="staff_id" class="select select-bordered w-full bg-white rounded-xl focus:border-brand-secondary" required>
                    <option disabled selected value="">-- Pilih Dokter --</option>
                    @foreach($doctors as $doc)
                        <option value="{{ $doc['id'] }}">{{ $doc['nama_lengkap'] }}</option>
                    @endforeach
                </select>
            </div>

            <div class="divider text-xs text-gray-400 mb-6">ATUR JADWAL HARIAN</div>

            <div class="space-y-4">
                @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $day)
                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-200">
                        <div class="flex flex-col md:flex-row gap-4 items-start md:items-center">
                            <!-- Checkbox Hari -->
                            <div class="flex items-center gap-3 w-32 shrink-0">
                                <input type="checkbox" name="jadwal[{{ $day }}][aktif]" value="1" class="checkbox checkbox-secondary" />
                                <span class="font-bold text-gray-700">{{ $day }}</span>
                            </div>

                            <!-- Input Fields -->
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 flex-1 w-full">
                                <div>
                                    <label class="text-[10px] text-gray-400 font-bold uppercase block mb-1">Mulai</label>
                                    <input type="time" name="jadwal[{{ $day }}][jam_mulai]" class="input input-sm input-bordered w-full bg-white">
                                </div>
                                <div>
                                    <label class="text-[10px] text-gray-400 font-bold uppercase block mb-1">Selesai</label>
                                    <input type="time" name="jadwal[{{ $day }}][jam_selesai]" class="input input-sm input-bordered w-full bg-white">
                                </div>
                                <div>
                                    <label class="text-[10px] text-gray-400 font-bold uppercase block mb-1">Kuota</label>
                                    <input type="number" name="jadwal[{{ $day }}][kuota]" value="20" class="input input-sm input-bordered w-full bg-white">
                                </div>
                                <div>
                                    <label class="text-[10px] text-gray-400 font-bold uppercase block mb-1">Status</label>
                                    <select name="jadwal[{{ $day }}][status]" class="select select-sm select-bordered w-full bg-white">
                                        <option value="Aktif" selected>Aktif</option>
                                        <option value="Nonaktif">Non-Aktif</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8 flex justify-end gap-3 border-t border-gray-100 pt-6">
                <a href="{{ route('admin.jadwal-dokter.index') }}" class="btn btn-ghost text-gray-500 rounded-xl">Batal</a>
                <button type="submit" class="btn bg-brand-secondary hover:bg-brand-secondary/90 text-white border-none px-8 rounded-xl shadow-lg">Simpan Jadwal</button>
            </div>
        </form>
    </div>
</div>
@endsection
