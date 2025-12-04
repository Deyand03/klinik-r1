@extends('layouts.sidebar')

@section('title', 'Edit Data Pegawai')

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
        <h1 class="text-2xl font-bold text-brand-dark">Edit Data Pegawai</h1>
    </div>

    <div class="bg-white rounded-3xl shadow-lg border border-gray-100 overflow-hidden">
        <form action="{{ route('admin.staff.update', $staff['id']) }}" method="POST" class="p-8" x-data="{ role: '{{ $staff['peran'] }}' }">
            @csrf
            @method('PUT')

            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Informasi Akun</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                <div class="form-control">
                    <label class="label"><span class="label-text font-semibold">Nama Lengkap</span></label>
                    <input type="text" name="nama_lengkap" value="{{ $staff['nama_lengkap'] }}" class="input input-bordered w-full rounded-xl bg-gray-50 focus:bg-white" required>
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text font-semibold">Email</span></label>
                    <input type="email" name="email" value="{{ $staff['user']['email'] ?? '' }}" class="input input-bordered w-full rounded-xl bg-gray-50 focus:bg-white" required>
                </div>
                <div class="form-control md:col-span-2">
                    <label class="label"><span class="label-text font-semibold">Password Baru <span class="text-gray-400 font-normal">(Isi hanya jika ingin mengganti)</span></span></label>
                    <input type="password" name="password" class="input input-bordered w-full rounded-xl bg-gray-50 focus:bg-white" placeholder="Biarkan kosong jika tidak diubah">
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text font-semibold">No. HP</span></label>
                    <input type="text" name="no_hp" value="{{ $staff['no_hp'] }}" class="input input-bordered w-full rounded-xl bg-gray-50 focus:bg-white">
                </div>
            </div>

            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4 mt-8">Posisi Pegawai</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                <div class="form-control">
                    <label class="label"><span class="label-text font-semibold">Penempatan Klinik</span></label>
                    <select name="id_klinik" class="select select-bordered w-full rounded-xl bg-gray-50 focus:bg-white" required>
                        @foreach($clinics as $clinic)
                            <option value="{{ $clinic['id'] }}" {{ $staff['id_klinik'] == $clinic['id'] ? 'selected' : '' }}>{{ $clinic['nama'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text font-semibold">Peran</span></label>
                    <select name="peran" x-model="role" class="select select-bordered w-full rounded-xl bg-gray-50 focus:bg-white" required>
                        <option value="admin">Admin</option>
                        <option value="dokter">Dokter</option>
                        <option value="perawat">Perawat</option>
                        <option value="resepsionis">Resepsionis</option>
                        <option value="kasir">Kasir</option>
                    </select>
                </div>
            </div>

            <!-- DETAIL KHUSUS DOKTER -->
            <div x-show="role === 'dokter'" x-transition class="mt-8 bg-blue-50/50 p-6 rounded-2xl border border-blue-100" style="display: none;">
                <h3 class="text-xs font-bold text-blue-500 uppercase tracking-widest mb-4">Detail Profil Dokter</h3>

                <div class="form-control mb-4">
                    <label class="label"><span class="label-text font-semibold text-gray-700">Spesialisasi</span></label>
                    <input type="text" name="spesialisasi" value="{{ $staff['spesialisasi'] }}" class="input input-bordered w-full rounded-xl bg-white">
                </div>
                <div class="form-control mb-4">
                    <label class="label"><span class="label-text font-semibold text-gray-700">Tentang Dokter</span></label>
                    <textarea name="tentang" class="textarea textarea-bordered w-full rounded-xl bg-white h-24">{{ $staff['tentang'] }}</textarea>
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text font-semibold text-gray-700">Pengalaman</span></label>
                    <input type="text" name="pengalaman" value="{{ $staff['pengalaman'] }}" class="input input-bordered w-full rounded-xl bg-white">
                </div>
            </div>

            <div class="mt-8 flex justify-end gap-3 pt-6 border-t border-gray-100">
                <a href="{{ route('admin.staff.index') }}" class="btn btn-ghost text-gray-500 rounded-xl">Batal</a>
                <button type="submit" class="btn bg-brand-secondary text-white border-none px-8 rounded-xl shadow-lg">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection
