@extends('layouts.sidebar')

@section('title', 'Edit Data Pegawai')

@section('content')
    <div class="container mx-auto px-4 max-w-2xl">

        @if (session('error'))
            <div class="mb-6 bg-red-50 text-red-600 p-4 rounded-xl border border-red-200">
                {{ session('error') }}
            </div>
        @endif

        <div class="flex items-center gap-4 mb-6">
            <a href="{{ route('admin.staff.index') }}" class="btn btn-circle btn-ghost text-gray-500 hover:bg-gray-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <h1 class="text-2xl font-bold text-brand-dark">Edit Data Pegawai</h1>
        </div>

        <div class="bg-white rounded-3xl shadow-lg border border-gray-100 overflow-hidden">
            <form action="{{ route('admin.staff.update', $staff['id']) }}" method="POST" class="p-8"
                x-data="{ role: '{{ $staff['peran'] }}' }" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Informasi Akun</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                    <div class="form-control">
                        <label class="label"><span class="label-text font-semibold">Nama Lengkap</span></label>
                        <input type="text" name="nama_lengkap" value="{{ $staff['nama_lengkap'] }}"
                            class="input input-bordered w-full rounded-xl bg-gray-50 focus:bg-white" required>
                    </div>
                    <div class="form-control">
                        <label class="label"><span class="label-text font-semibold">Email</span></label>
                        <input type="email" name="email" value="{{ $staff['user']['email'] ?? '' }}"
                            class="input input-bordered w-full rounded-xl bg-gray-50 focus:bg-white" required>
                    </div>
                    <div class="form-control md:col-span-2">
                        <label class="label"><span class="label-text font-semibold">Password Baru <span
                                    class="text-gray-400 font-normal">(Isi hanya jika ingin mengganti)</span></span></label>
                        <input type="password" name="password"
                            class="input input-bordered w-full rounded-xl bg-gray-50 focus:bg-white"
                            placeholder="Biarkan kosong jika tidak diubah">
                    </div>
                    <div class="form-control">
                        <label class="label"><span class="label-text font-semibold">No. HP</span></label>
                        <input type="text" name="no_hp" value="{{ $staff['no_hp'] }}"
                            class="input input-bordered w-full rounded-xl bg-gray-50 focus:bg-white">
                    </div>
                </div>

                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4 mt-8">Posisi Pegawai</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                    <div class="form-control">
                        <label class="label"><span class="label-text font-semibold">Penempatan Klinik</span></label>
                        <select name="id_klinik" class="select select-bordered w-full rounded-xl bg-gray-50 focus:bg-white"
                            required>
                            @foreach ($clinics as $clinic)
                                <option value="{{ $clinic['id'] }}"
                                    {{ $staff['id_klinik'] == $clinic['id'] ? 'selected' : '' }}>{{ $clinic['nama'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-control">
                        <label class="label"><span class="label-text font-semibold">Peran</span></label>
                        <select name="peran" x-model="role"
                            class="select select-bordered w-full rounded-xl bg-gray-50 focus:bg-white" required>
                            <option value="admin">Admin</option>
                            <option value="dokter">Dokter</option>
                            <option value="perawat">Perawat</option>
                            <option value="resepsionis">Resepsionis</option>
                            <option value="kasir">Kasir</option>
                        </select>
                    </div>
                </div>

                <!-- DETAIL KHUSUS DOKTER -->
                <div x-show="role === 'dokter'" x-transition
                    class="mt-8 bg-blue-50/50 p-6 rounded-2xl border border-blue-100" style="display: none;">
                    <h3 class="text-xs font-bold text-blue-500 uppercase tracking-widest mb-4">Detail Profil Dokter</h3>

                    <!-- UPLOAD FOTO DENGAN PREVIEW FOTO LAMA -->
                    <div class="form-control mb-5" x-data="{
                        photoName: null,
                        photoPreview: '{{ !empty($staff['foto_profil']) ? str_replace('/api', '', env('API_URL')) . '/storage/' . $staff['foto_profil'] : 'https://ui-avatars.com/api/?name=' . urlencode($staff['nama_lengkap']) . '&background=A8FBD3&color=31326F' }}'
                    }">
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
                            <div class="mt-2 flex justify-center rounded-2xl border-2 border-dashed border-gray-300 px-6 pt-10 pb-10 transition-all hover:border-brand-secondary hover:bg-blue-50/50"
                                :class="photoPreview ? 'border-brand-secondary bg-blue-50/30' : ''">

                                <!-- State Kosong (Gak ada foto lama & Gak ada upload baru) -->
                                <div class="space-y-1 text-center" x-show="!photoPreview">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none"
                                        viewBox="0 0 48 48" aria-hidden="true">
                                        <path
                                            d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600 justify-center">
                                        <span
                                            class="relative cursor-pointer rounded-md font-medium text-brand-secondary focus-within:outline-none focus-within:ring-2 focus-within:ring-brand-secondary focus-within:ring-offset-2 hover:text-brand-secondary/80">
                                            <span>Upload foto baru</span>
                                        </span>
                                    </div>
                                    <p class="text-xs text-gray-500">JPG, PNG, Max 2MB</p>
                                </div>

                                <!-- State Ada Foto (Entah lama atau baru) -->
                                <div class="text-center" x-show="photoPreview" style="display: none;">
                                    <div class="relative inline-block">
                                        <span
                                            class="block h-32 w-32 rounded-2xl overflow-hidden shadow-md bg-gray-100 ring-2 ring-white">
                                            <img :src="photoPreview" class="h-full w-full object-cover"
                                                alt="Preview Foto">
                                        </span>
                                        <!-- Badge Info -->
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
                                    <p class="text-xs text-brand-secondary font-bold mt-3"
                                        x-text="photoName ? 'File baru: ' + photoName : 'Foto saat ini'"></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-control mb-4">
                        <label class="label"><span
                                class="label-text font-semibold text-gray-700">Spesialisasi</span></label>
                        <input type="text" name="spesialisasi" value="{{ $staff['spesialisasi'] }}"
                            class="input input-bordered w-full rounded-xl bg-white">
                    </div>
                    <div class="form-control mb-4">
                        <label class="label"><span class="label-text font-semibold text-gray-700">Tentang
                                Dokter</span></label>
                        <textarea name="tentang" class="textarea textarea-bordered w-full rounded-xl bg-white h-24">{{ $staff['tentang'] }}</textarea>
                    </div>
                    <div class="form-control">
                        <label class="label"><span
                                class="label-text font-semibold text-gray-700">Pengalaman</span></label>
                        <input type="text" name="pengalaman" value="{{ $staff['pengalaman'] }}"
                            class="input input-bordered w-full rounded-xl bg-white">
                    </div>
                </div>

                <div class="mt-8 flex justify-end gap-3 pt-6 border-t border-gray-100">
                    <a href="{{ route('admin.staff.index') }}" class="btn btn-ghost text-gray-500 rounded-xl">Batal</a>
                    <button type="submit"
                        class="btn bg-brand-secondary text-white border-none px-8 rounded-xl shadow-lg">Simpan
                        Perubahan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
