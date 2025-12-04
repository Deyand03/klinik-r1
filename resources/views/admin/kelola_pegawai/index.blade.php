@extends('layouts.sidebar')

@section('title', 'Kelola Pegawai')

@section('content')
<div class="container mx-auto px-4">

    @if(session('success'))
        <div class="mb-6 bg-green-50 text-green-700 p-4 rounded-xl border border-green-200 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-brand-dark">Data Pegawai</h1>
            <p class="text-gray-500 text-sm">Kelola akun dokter, admin, dan staff klinik.</p>
        </div>
        <a href="{{ route('admin.staff.create') }}" class="btn bg-brand-secondary text-white border-none rounded-xl shadow-lg px-6 gap-2 hover:bg-brand-secondary/90 transition-all">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Pegawai
        </a>
    </div>

    <!-- FILTER BAR -->
    <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 mb-6">
        <form method="GET" action="{{ route('admin.staff.index') }}" class="flex flex-col md:flex-row gap-4">
            <div class="form-control w-full md:w-64">
                <select name="clinic_id" class="select select-bordered w-full bg-white rounded-xl" onchange="this.form.submit()">
                    <option value="all">Semua Klinik</option>
                    @foreach($clinics as $clinic)
                        <option value="{{ $clinic['id'] }}" {{ request('clinic_id') == $clinic['id'] ? 'selected' : '' }}>{{ $clinic['nama'] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-control w-full relative">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email..." class="input input-bordered w-full rounded-xl pl-10">
                <svg class="w-5 h-5 absolute left-3 top-2.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <button type="submit" class="font-semibold bg-brand-secondary text-white shadow-lg hover:bg-brand-secondary/70 rounded-xl px-6">Cari</button>
        </form>
    </div>

    <!-- TABLE LIST -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="table w-full">
                <thead class="bg-gray-50 text-gray-500 uppercase text-xs font-bold">
                    <tr>
                        <th class="pl-6 py-4">Nama & Email</th>
                        <th>Peran</th>
                        <th>Klinik</th>
                        <th>Kontak</th>
                        <th class="text-right pr-6">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($staffs as $staff)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="pl-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="avatar placeholder">
                                    <div class="bg-brand-secondary/10 text-brand-secondary rounded-xl w-10 h-10 flex flex-col justify-center items-center">
                                        <span class="text-lg font-bold">{{ substr($staff['nama_lengkap'], 0, 1) }}</span>
                                    </div>
                                </div>
                                <div>
                                    <div class="font-bold text-brand-dark">{{ $staff['nama_lengkap'] }}</div>
                                    <div class="text-xs text-gray-400">{{ $staff['user']['email'] ?? '-' }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            @php
                                $colors = [
                                    'dokter' => 'bg-blue-100 text-blue-700',
                                    'admin' => 'bg-purple-100 text-purple-700',
                                    'perawat' => 'bg-green-100 text-green-700',
                                    'resepsionis' => 'bg-pink-100 text-pink-700',
                                    'kasir' => 'bg-orange-100 text-orange-700'
                                ];
                                $roleColor = $colors[$staff['peran']] ?? 'bg-gray-100 text-gray-500';
                            @endphp
                            <span class="badge {{ $roleColor }} border-none rounded-xl font-bold py-3 px-3 uppercase text-[10px] tracking-wide">
                                {{ $staff['peran'] }}
                            </span>
                        </td>
                        <td>
                            <div class="font-medium text-sm text-gray-600">{{ $staff['klinik']['nama'] ?? '-' }}</div>
                        </td>
                        <td class="font-mono text-xs text-gray-500">{{ $staff['no_hp'] ?? '-' }}</td>
                        <td class="text-right pr-6">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.staff.edit', $staff['id']) }}" class="btn btn-sm btn-ghost hover:bg-brand-primary/20 text-brand-dark rounded-lg">
                                    Edit
                                </a>
                                <form action="{{ route('admin.staff.destroy', $staff['id']) }}" method="POST" onsubmit="return confirm('Yakin hapus pegawai ini? User akun juga akan terhapus.')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-ghost hover:bg-red-50 text-red-500 rounded-lg">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-12 text-gray-400">
                            Tidak ada data pegawai.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
