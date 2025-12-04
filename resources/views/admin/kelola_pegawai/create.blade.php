@extends('layouts.sidebar')

@section('title', 'Tambah Pegawai Baru')

@section('content')
<div class="container mx-auto px-4 max-w-2xl">

    @if(session('error'))
        <div class="mb-6 bg-red-50 text-red-600 p-4 rounded-xl border border-red-200">
            {{ session('error') }}
        </div>
    @endif

    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('admin.staff.index') }}" class="btn btn-circle btn-ghost text-gray-500 hover:bg-gray-100">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </a>
        <h1 class="text-2xl font-bold text-brand-dark">Tambah Pegawai</h1>
    </div>

    <div class="bg-white rounded-3xl shadow-lg border border-gray-100 overflow-hidden">
        <!-- x-data untuk kontrol form dinamis -->
        <form action="{{ route('admin.staff.store') }}" method="POST" class="p-8" x-data="{ role: '{{ old('peran', 'admin') }}' }">
            @csrf

            <!-- INFORMASI DASAR -->
            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Informasi Akun & Pribadi</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                <div class="form-control">
                    <label class="label"><span class="label-text font-semibold">Nama Lengkap</span></label>
                    <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" class="input input-bordered w-full rounded-xl bg-gray-50 focus:bg-white" required placeholder="Cth: Dr. Budi Santoso">
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text font-semibold">Email (Untuk Login)</span></label>
                    <input type="email" name="email" value="{{ old('email') }}" class="input input-bordered w-full rounded-xl bg-gray-50 focus:bg-white" required placeholder="email@klinik.com">
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text font-semibold">Password</span></label>
                    <input type="password" name="password" class="input input-bordered w-full rounded-xl bg-gray-50 focus:bg-white" required placeholder="Minimal 6 karakter">
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text font-semibold">No. HP</span></label>
                    <input type="text" name="no_hp" value="{{ old('no_hp') }}" class="input input-bordered w-full rounded-xl bg-gray-50 focus:bg-white" placeholder="0812...">
                </div>
            </div>

            <!-- POSISI & KLINIK -->
            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4 mt-8">Posisi Pegawai</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                <div class="form-control">
                    <label class="label"><span class="label-text font-semibold">Penempatan Klinik</span></label>
                    <select name="id_klinik" class="select select-bordered w-full rounded-xl bg-gray-50 focus:bg-white" required>
                        <option value="" disabled selected>-- Pilih Klinik --</option>
                        @foreach($clinics as $clinic)
                            <option value="{{ $clinic['id'] }}" {{ old('id_klinik') == $clinic['id'] ? 'selected' : '' }}>{{ $clinic['nama'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text font-semibold">Peran / Jabatan</span></label>
                    <!-- x-model binding ke role -->
                    <select name="peran" x-model="role" class="select select-bordered w-full rounded-xl bg-gray-50 focus:bg-white" required>
                        <option value="admin">Admin</option>
                        <option value="dokter">Dokter</option>
                        <option value="perawat">Perawat</option>
                        <option value="resepsionis">Resepsionis</option>
                        <option value="kasir">Kasir</option>
                    </select>
                </div>
            </div>

            <!-- DETAIL KHUSUS DOKTER (Dynamic View) -->
            <div x-show="role === 'dokter'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform -translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0" class="mt-8 bg-blue-50/50 p-6 rounded-2xl border border-blue-100" style="display: none;">
                <h3 class="text-xs font-bold text-blue-500 uppercase tracking-widest mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Detail Profil Dokter
                </h3>

                <div class="form-control mb-4">
                    <label class="label"><span class="label-text font-semibold text-gray-700">Spesialisasi</span></label>
                    <input type="text" name="spesialisasi" value="{{ old('spesialisasi') }}" class="input input-bordered w-full rounded-xl bg-white" placeholder="Cth: Spesialis Anak, Umum, Gigi">
                </div>

                <div class="form-control mb-4">
                    <label class="label"><span class="label-text font-semibold text-gray-700">Tentang Dokter</span></label>
                    <textarea name="tentang" class="textarea textarea-bordered w-full rounded-xl bg-white h-24" placeholder="Deskripsi singkat profil dokter...">{{ old('tentang') }}</textarea>
                </div>

                <div class="form-control">
                    <label class="label"><span class="label-text font-semibold text-gray-700">Pengalaman (Tahun/Deskripsi)</span></label>
                    <input type="text" name="pengalaman" value="{{ old('pengalaman') }}" class="input input-bordered w-full rounded-xl bg-white" placeholder="Cth: 10 Tahun di RS Pusat">
                </div>
            </div>

            <div class="mt-8 flex justify-end gap-3 pt-6 border-t border-gray-100">
                <a href="{{ route('admin.staff.index') }}" class="btn btn-ghost text-gray-500 rounded-xl">Batal</a>
                <button type="submit" class="btn bg-brand-secondary text-white border-none px-8 rounded-xl shadow-lg hover:-translate-y-0.5 transition-transform">Simpan Pegawai</button>
            </div>
        </form>
    </div>
</div>
@endsection
