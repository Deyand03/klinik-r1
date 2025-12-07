@extends('layouts.sidebar')

@section('title', 'Tambah Pegawai Baru')

@section('content')
    <div class="container mx-auto px-4 max-w-2xl">

        <!-- Notif Error Global (Optional jika sudah ada detail per field) -->
        @if (session('error'))
            <div class="mb-6 bg-red-50 text-red-600 p-4 rounded-xl border border-red-200 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ session('error') }}
            </div>
        @endif

        <div class="flex items-center gap-4 mb-6">
            <a href="{{ route('admin.staff.index') }}" class="btn btn-circle btn-ghost text-gray-500 hover:bg-gray-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <h1 class="text-2xl font-bold text-brand-dark">Tambah Pegawai</h1>
        </div>

        <div class="bg-white rounded-3xl shadow-lg border border-gray-100 overflow-hidden">
            <form action="{{ route('admin.staff.store') }}" method="POST" class="p-8" x-data="{ role: '{{ old('peran', 'admin') }}' }"
                enctype="multipart/form-data">
                @csrf

                <!-- INFORMASI DASAR -->
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Informasi Akun & Pribadi</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                    <!-- Nama Lengkap -->
                    <div class="form-control">
                        <label class="label"><span class="label-text font-semibold">Nama Lengkap</span></label>
                        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}"
                            class="input input-bordered w-full rounded-xl bg-gray-50 focus:bg-white @error('nama_lengkap') input-error bg-red-50 @enderror"
                            placeholder="Cth: Dr. Budi Santoso" required>
                        @error('nama_lengkap')
                            <span class="text-red-500 text-xs mt-1 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="form-control">
                        <label class="label"><span class="label-text font-semibold">Email (Untuk Login)</span></label>
                        <input type="email" name="email" value="{{ old('email') }}"
                            class="input input-bordered w-full rounded-xl bg-gray-50 focus:bg-white @error('email') input-error bg-red-50 @enderror"
                            placeholder="email@klinik.com" required>
                        @error('email')
                            <span class="text-red-500 text-xs mt-1 flex items-center gap-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="form-control">
                        <label class="label"><span class="label-text font-semibold">Password</span></label>
                        <input type="password" name="password"
                            class="input input-bordered w-full rounded-xl bg-gray-50 focus:bg-white @error('password') input-error bg-red-50 @enderror"
                            placeholder="Minimal 6 karakter" required>
                        @error('password')
                            <span class="text-red-500 text-xs mt-1 flex items-center gap-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- No HP -->
                    <div class="form-control">
                        <label class="label"><span class="label-text font-semibold">No. HP</span></label>
                        <input type="number" name="no_hp" value="{{ old('no_hp') }}"
                            class="input input-bordered w-full rounded-xl bg-gray-50 focus:bg-white @error('no_hp') input-error bg-red-50 @enderror"
                            placeholder="0812..." required>
                        @error('no_hp')
                            <span class="text-red-500 text-xs mt-1 flex items-center gap-1">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- POSISI & KLINIK -->
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4 mt-8">Posisi Pegawai</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                    <!-- Klinik -->
                    <div class="form-control">
                        <label class="label"><span class="label-text font-semibold">Penempatan Klinik</span></label>
                        <select name="id_klinik"
                            class="select select-bordered w-full rounded-xl bg-gray-50 focus:bg-white @error('id_klinik') select-error bg-red-50 @enderror">
                            <option value="" disabled selected>-- Pilih Klinik --</option>
                            @foreach ($clinics as $clinic)
                                <option value="{{ $clinic['id'] }}"
                                    {{ old('id_klinik') == $clinic['id'] ? 'selected' : '' }}>{{ $clinic['nama'] }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_klinik')
                            <span class="text-red-500 text-xs mt-1 flex items-center gap-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Peran -->
                    <div class="form-control">
                        <label class="label"><span class="label-text font-semibold">Peran / Jabatan</span></label>
                        <select name="peran" x-model="role"
                            class="select select-bordered w-full rounded-xl bg-gray-50 focus:bg-white @error('peran') select-error bg-red-50 @enderror">
                            <option value="admin">Admin</option>
                            <option value="dokter">Dokter</option>
                            <option value="perawat">Perawat</option>
                            <option value="resepsionis">Resepsionis</option>
                            <option value="kasir">Kasir</option>
                        </select>
                        @error('peran')
                            <span class="text-red-500 text-xs mt-1 flex items-center gap-1">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- DETAIL KHUSUS DOKTER -->
                <div x-show="role === 'dokter'" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform -translate-y-2"
                    x-transition:enter-end="opacity-100 transform translate-y-0"
                    class="mt-8 bg-blue-50/50 p-6 rounded-2xl border border-blue-100" style="display: none;">
                    <h3 class="text-xs font-bold text-blue-500 uppercase tracking-widest mb-4 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                        Detail Profil Dokter
                    </h3>

                    <!-- FOTO PROFIL -->
                    <div class="form-control mb-5" x-data="{ photoName: null, photoPreview: null }">
                        <label class="label"><span class="label-text font-semibold text-gray-700">Foto
                                Profil</span></label>
                        <input type="file" name="foto_profil" id="foto_profil" class="hidden" x-ref="photo"
                            x-on:change="
                            photoName = $refs.photo.files[0].name;
                            const reader = new FileReader();
                            reader.onload = (e) => { photoPreview = e.target.result; };
                            reader.readAsDataURL($refs.photo.files[0]);
                        ">
                        <div class="relative group cursor-pointer" x-on:click="$refs.photo.click()">
                            <div class="mt-2 flex justify-center rounded-2xl border-2 border-dashed px-6 pt-10 pb-10 transition-all hover:border-brand-secondary hover:bg-blue-50/50"
                                :class="photoPreview ? 'border-brand-secondary bg-blue-50/30' :
                                    'border-gray-300 @error('foto_profil') border-red-400 bg-red-50/30 @enderror'">

                                <div class="space-y-1 text-center" x-show="!photoPreview">
                                    <svg class="mx-auto h-12 w-12 @error('foto_profil') text-red-400 @else text-gray-400 @enderror"
                                        stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                        <path
                                            d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600 justify-center">
                                        <span
                                            class="relative cursor-pointer rounded-md font-medium text-brand-secondary focus-within:outline-none focus-within:ring-2 focus-within:ring-brand-secondary focus-within:ring-offset-2 hover:text-brand-secondary/80">
                                            <span>Klik untuk upload gambar</span>
                                        </span>
                                    </div>
                                    <p class="text-xs text-gray-500">JPG, PNG, Max 2MB</p>
                                </div>

                                <div class="text-center" x-show="photoPreview" style="display: none;">
                                    <div class="relative inline-block">
                                        <span
                                            class="block h-32 w-32 rounded-2xl overflow-hidden shadow-md bg-gray-100 ring-2 ring-white">
                                            <img :src="photoPreview" class="h-full w-full object-cover"
                                                alt="Preview Foto">
                                        </span>
                                        <div
                                            class="absolute -top-2 -right-2 bg-white rounded-full p-1 shadow-md cursor-pointer hover:bg-gray-100 text-gray-500">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                                </path>
                                            </svg>
                                        </div>
                                    </div>
                                    <p class="text-xs text-brand-secondary font-bold mt-3" x-text="photoName"></p>
                                </div>
                            </div>
                        </div>
                        @error('foto_profil')
                            <span
                                class="text-red-500 text-xs mt-1 flex items-center gap-1 text-center justify-center">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Spesialisasi -->
                    <div class="form-control mb-4">
                        <label class="label"><span
                                class="label-text font-semibold text-gray-700">Spesialisasi</span></label>
                        <input type="text" name="spesialisasi" value="{{ old('spesialisasi') }}"
                            class="input input-bordered w-full rounded-xl bg-white @error('spesialisasi') input-error bg-red-50 @enderror"
                            placeholder="Cth: Spesialis Anak, Umum, Gigi">
                        @error('spesialisasi')
                            <span class="text-red-500 text-xs mt-1 flex items-center gap-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Tentang -->
                    <div class="form-control mb-4">
                        <label class="label"><span class="label-text font-semibold text-gray-700">Tentang
                                Dokter</span></label>
                        <textarea name="tentang"
                            class="textarea textarea-bordered w-full rounded-xl bg-white h-24 @error('tentang') textarea-error bg-red-50 @enderror"
                            placeholder="Deskripsi singkat profil dokter...">{{ old('tentang') }}</textarea>
                        @error('tentang')
                            <span class="text-red-500 text-xs mt-1 flex items-center gap-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Pengalaman -->
                    <div class="form-control">
                        <label class="label"><span class="label-text font-semibold text-gray-700">Pengalaman
                                (Tahun/Deskripsi)</span></label>
                        <input type="text" name="pengalaman" value="{{ old('pengalaman') }}"
                            class="input input-bordered w-full rounded-xl bg-white @error('pengalaman') input-error bg-red-50 @enderror"
                            placeholder="Cth: 10 Tahun di RS Pusat">
                        @error('pengalaman')
                            <span class="text-red-500 text-xs mt-1 flex items-center gap-1">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mt-8 flex justify-end gap-3 pt-6 border-t border-gray-100">
                    <a href="{{ route('admin.staff.index') }}" class="btn btn-ghost text-gray-500 rounded-xl">Batal</a>
                    <button type="submit"
                        class="btn bg-brand-secondary text-white border-none px-8 rounded-xl shadow-lg hover:-translate-y-0.5 transition-transform">Simpan
                        Pegawai</button>
                </div>
            </form>
        </div>
    </div>
@endsection
