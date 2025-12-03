@extends('layouts.sidebar')

@section('title', 'Manajemen Jadwal Dokter')

@section('content')
    <div x-data="{
        addModalOpen: false,
        editModalOpen: false,
        selectedJadwal: null,

        // State Filter Frontend (Visual Filtering)
        searchTerm: '',
        filterHari: '',
        filterStatus: '',

        // URL Template untuk Edit (ID dummy ':id' nanti direplace ID asli)
        updateUrlTemplate: '',

        openEdit(data) {
            this.selectedJadwal = data;
            this.editModalOpen = true;
        }
    }">

        <!-- ALERT MESSAGES (Flash Session) -->
        @if(session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg flex items-start gap-3 shadow-sm animate-pulse">
                <div class="text-green-500"><svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg></div>
                <div>
                    <h3 class="text-sm font-bold text-green-800">Berhasil</h3>
                    <p class="text-sm text-green-600">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg flex items-start gap-3 shadow-sm animate-pulse">
                <div class="text-red-500"><svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg></div>
                <div>
                    <h3 class="text-sm font-bold text-red-800">Gagal</h3>
                    <p class="text-sm text-red-600">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        @if(session('warning'))
            <div class="mb-6 bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded-r-lg flex items-start gap-3 shadow-sm animate-pulse">
                <div class="text-yellow-500"><svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg></div>
                <div>
                    <h3 class="text-sm font-bold text-yellow-800">Perhatian</h3>
                    <p class="text-sm text-yellow-700">{{ session('warning') }}</p>
                </div>
            </div>
        @endif

        <!-- HEADER PAGE -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
            <div>
                <h1 class="text-2xl font-bold text-brand-dark">Jadwal Praktek Dokter</h1>
                <p class="text-gray-500 text-sm mt-1">Kelola hari dan jam kerja dokter di klinik.</p>
            </div>

            <button @click="addModalOpen = true"
                class="btn bg-brand-secondary hover:bg-brand-secondary/90 text-white border-none gap-2 shadow-lg shadow-brand-secondary/30 rounded-xl px-6 transform hover:-translate-y-1 transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Jadwal
            </button>
        </div>

        <!-- FILTER BAR -->
        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 mb-8">
            <div class="flex flex-col md:flex-row gap-4 items-end">
                <!-- Filter Nama -->
                <div class="form-control w-full md:flex-1">
                    <label class="label pb-1"><span class="label-text font-bold text-gray-500 text-xs uppercase tracking-wider">Cari Dokter</span></label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                            <svg class="h-[1em] opacity-50 z-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none"
                                stroke="currentColor">
                                <circle cx="11" cy="11" r="8"></circle>
                                <path d="m21 21-4.3-4.3"></path>
                            </g>
                        </svg>
                        </span>
                        <input type="text" x-model="searchTerm" placeholder="Ketik nama..." class="input input-bordered w-full pl-10 bg-gray-50 focus:bg-white focus:border-brand-secondary rounded-xl transition-all" />
                    </div>
                </div>

                <!-- Filter Hari -->
                <div class="form-control w-full md:w-48">
                    <label class="label pb-1"><span class="label-text font-bold text-gray-500 text-xs uppercase tracking-wider">Hari</span></label>
                    <select x-model="filterHari" class="select select-bordered bg-gray-50 focus:bg-white focus:border-brand-secondary rounded-xl w-full">
                        <option value="">Semua</option>
                        @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $hari)
                            <option value="{{ $hari }}">{{ $hari }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter Status -->
                <div class="form-control w-full md:w-40">
                    <label class="label pb-1"><span class="label-text font-bold text-gray-500 text-xs uppercase tracking-wider">Status</span></label>
                    <select x-model="filterStatus" class="select select-bordered bg-gray-50 focus:bg-white focus:border-brand-secondary rounded-xl w-full">
                        <option value="">Semua</option>
                        <option value="aktif">Aktif</option>
                        <option value="nonaktif">Non-Aktif</option>
                    </select>
                </div>

                <button @click="searchTerm=''; filterHari=''; filterStatus=''" type="button" class="btn btn-outline border-gray-200 text-gray-600 hover:bg-gray-100 rounded-xl">
                    Reset
                </button>
            </div>
        </div>

        <!-- GRID JADWAL (DINAMIS) -->
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

            @forelse ($schedules as $item)
                {{-- Logic Filter AlpineJS: Sembunyikan kartu di browser jika tidak sesuai filter --}}
                <div x-show="(searchTerm === '' || '{{ strtolower($item['dokter']) }}'.includes(searchTerm.toLowerCase())) &&
                             (filterHari === '' || {{ json_encode($item['hari']) }}.includes(filterHari)) &&
                             (filterStatus === '' || '{{ $item['status'] }}' === filterStatus)"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 scale-90"
                     x-transition:enter-end="opacity-100 scale-100"
                     class="flex flex-col justify-between gap-2 bg-white shadow-sm rounded-2xl px-6 py-5 border border-gray-100 border-l-[6px] {{ $item['status'] == 'aktif' ? 'border-l-brand-secondary' : 'border-l-gray-300' }} transition-all duration-300 hover:-translate-y-2 hover:shadow-xl group">

                    <div>
                        <!-- Header Card -->
                        <div class="flex justify-between items-start pl-2">
                            <div class="flex items-center gap-4">
                                <div class="avatar {{ $item['status'] == 'aktif' ? 'online' : 'offline' }}">
                                    <div class="w-14 h-14 rounded-2xl ring-2 ring-offset-2 {{ $item['status'] == 'aktif' ? 'ring-brand-secondary/30' : 'ring-gray-200' }}">
                                        <!-- Avatar Dinamis dari Nama Dokter -->
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($item['dokter']) }}&background=random&bold=true" />
                                    </div>
                                </div>
                                <div class="flex flex-col">
                                    <h3 class="font-bold text-lg text-brand-dark group-hover:text-brand-btn transition">{{ $item['dokter'] }}</h3>
                                    <h4 class="text-xs text-gray-500 font-medium uppercase tracking-wide">{{ $item['spesialis'] }}</h4>
                                </div>
                            </div>

                            <!-- Status Badge -->
                            <span class="badge {{ $item['status'] == 'aktif' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }} border-none font-bold text-xs py-3 px-3">
                                {{ $item['status'] == 'aktif' ? 'Aktif' : 'Non-Aktif' }}
                            </span>
                        </div>

                        <!-- Info Jadwal -->
                        <div class="bg-gray-50 border border-gray-100 px-4 py-4 mt-5 rounded-xl space-y-3">
                            <div class="flex justify-between items-start">
                                <div class="text-[10px] text-gray-400 uppercase tracking-wider font-bold mt-1">Hari</div>
                                <div class="flex flex-wrap justify-end gap-1.5 max-w-[70%]">
                                    @foreach($item['hari'] as $h)
                                        <span class="px-2 py-1 rounded-md text-[10px] font-bold border {{ $item['status'] == 'aktif' ? 'bg-white border-brand-secondary/30 text-brand-secondary' : 'bg-white border-gray-200 text-gray-400' }}">
                                            {{ substr($h, 0, 3) }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                            <div class="flex justify-between items-center pt-2 border-t border-gray-200/50">
                                <div class="text-[10px] text-gray-400 uppercase tracking-wider font-bold">Jam</div>
                                <div class="text-sm font-mono font-bold text-brand-dark">
                                    {{ $item['jam_mulai'] }} - {{ $item['jam_selesai'] }}
                                </div>
                            </div>
                        </div>

                        <!-- Kuota Progress -->
                        <div class="pl-1 pt-5">
                            <div class="flex justify-between text-xs mb-1.5">
                                <span class="text-gray-500">Terisi Hari Ini</span>
                                <span class="font-bold {{ $item['terisi'] >= $item['kuota'] ? 'text-red-500' : 'text-brand-secondary' }}">
                                    {{ $item['terisi'] }} <span class="text-gray-400 font-normal">/ {{ $item['kuota'] }}</span>
                                </span>
                            </div>
                            <!-- Hitung Persentase Progress -->
                            @php
                                $percent = $item['kuota'] > 0 ? ($item['terisi'] / $item['kuota']) * 100 : 0;
                            @endphp
                            <progress class="progress w-full h-2 {{ $item['terisi'] >= $item['kuota'] ? 'progress-error' : ($item['status'] == 'aktif' ? 'progress-success' : 'progress-secondary') }}"
                                      value="{{ $item['terisi'] }}" max="{{ $item['kuota'] }}"></progress>

                            @if($item['terisi'] >= $item['kuota'])
                                <p class="text-[10px] text-red-500 mt-1 font-bold text-right">KUOTA PENUH</p>
                            @endif
                        </div>
                    </div>

                    <!-- Tombol Edit -->
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <!-- Passing Data JSON ke AlpineJS openEdit() -->
                        <button @click="openEdit({{ json_encode($item) }})"
                                class="btn btn-block btn-sm btn-outline border-gray-200 hover:bg-brand-primary hover:border-brand-primary hover:text-brand-dark normal-case font-bold rounded-xl transition-all">
                            Edit Jadwal
                        </button>
                    </div>
                </div>
            @empty
                <!-- Empty State -->
                <div class="col-span-1 md:col-span-2 xl:col-span-3 text-center py-12 bg-gray-50 rounded-2xl border-2 border-dashed border-gray-300">
                    <div class="text-gray-400 mb-2">📅</div>
                    <p class="text-gray-500 font-medium">Belum ada jadwal dokter yang tersedia.</p>
                    <button @click="addModalOpen = true"
                        class="text-brand-secondary hover:underline text-sm font-bold mt-2">Buat jadwal baru
                        sekarang</button>
                </div>
            @endforelse

        </div>

        <!-- ==================================================================== -->
        <!-- 4. MODAL TAMBAH (ADD) -->
        <!-- ==================================================================== -->
        <div x-show="addModalOpen" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
            <div x-show="addModalOpen" x-transition.opacity class="fixed inset-0 bg-brand-dark/60 backdrop-blur-md transition-opacity" @click="addModalOpen = false"></div>

            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-gray-100">
                    <div class="px-8 py-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                        <h3 class="text-xl font-bold text-brand-dark">Tambah Jadwal Baru</h3>
                        <button @click="addModalOpen = false" class="text-gray-400 hover:text-red-500"><svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg></button>
                    </div>

                    <div class="px-8 py-6">
                        <form action="{{ route('admin.jadwal-dokter.store') }}" method="POST">
                            @csrf

                            <!-- Dropdown Dokter Dinamis -->
                            <div class="mb-5">
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Pilih Dokter</label>
                                <select name="staff_id" class="select select-bordered w-full bg-white focus:border-brand-secondary rounded-xl" required>
                                    <option disabled selected value="">-- Pilih Dokter --</option>
                                    @foreach($doctors as $doc)
                                        <option value="{{ $doc['id'] }}">{{ $doc['nama'] }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Status & Kuota -->
                            <div class="grid grid-cols-2 gap-5 mb-5">
                                <div>
                                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Status</label>
                                    <select name="status" class="select select-bordered w-full bg-white rounded-xl">
                                        <option value="aktif" selected>Aktif</option>
                                        <option value="nonaktif">Non-Aktif</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Kuota</label>
                                    <input type="number" name="kuota" value="20" class="input input-bordered w-full bg-white rounded-xl" required>
                                </div>
                            </div>

                            <!-- Jam -->
                            <div class="grid grid-cols-2 gap-5 mb-6">
                                <div>
                                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Jam Mulai</label>
                                    <input type="time" name="jam_mulai" class="input input-bordered w-full bg-white rounded-xl" required>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Jam Selesai</label>
                                    <input type="time" name="jam_selesai" class="input input-bordered w-full bg-white rounded-xl" required>
                                </div>
                            </div>

                            <!-- Checkbox Hari -->
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Hari
                                    Praktek</label>
                                <div class="flex flex-wrap gap-2">
                                    @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $day)
                                        <label class="cursor-pointer relative">
                                            <input type="checkbox" name="hari[]" value="{{ $day }}" class="peer sr-only" />
                                            <div class="px-4 py-2 rounded-xl text-sm font-semibold border border-gray-200 text-gray-500 bg-white transition-all peer-checked:bg-brand-secondary peer-checked:text-white peer-checked:border-brand-secondary hover:bg-gray-50">
                                                {{ $day }}
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div class="mt-8 flex flex-row-reverse gap-3">
                                <button type="submit" class="btn bg-brand-secondary hover:bg-brand-secondary/90 text-white border-none px-6 rounded-xl shadow-lg hover:-translate-y-0.5 transition-all">Simpan</button>
                                <button type="button" @click="addModalOpen = false" class="btn btn-ghost text-gray-500 rounded-xl">Batal</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- ==================================================================== -->
        <!-- 5. MODAL EDIT (UPDATE) -->
        <!-- ==================================================================== -->
        <div x-show="editModalOpen" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
            <div x-show="editModalOpen" x-transition.opacity class="fixed inset-0 bg-brand-dark/60 backdrop-blur-md transition-opacity" @click="editModalOpen = false"></div>

            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-gray-100">
                    <div class="px-8 py-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                        <h3 class="text-xl font-bold text-brand-dark">Edit Jadwal Dokter</h3>
                        <button @click="editModalOpen = false" class="text-gray-400 hover:text-red-500"><svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg></button>
                    </div>

                    <div class="px-8 py-6">
                        <!-- FORM EDIT: Action URL Dinamis -->
                        <!-- Mengganti ':id' dengan ID Jadwal asli yang dikirim dari Backend -->
                        <form method="POST" :action="updateUrlTemplate.replace(999, selectedJadwal?.id)">
                            @csrf
                            @method('PUT')

                            <div class="mb-5">
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Dokter</label>
                                <div class="bg-gray-100 rounded-xl px-4 py-3 border border-gray-200 text-gray-600 font-medium">
                                    <span x-text="selectedJadwal?.dokter"></span>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-5 mb-5">
                                <div>
                                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Status</label>
                                    <select name="status" class="select select-bordered w-full bg-white rounded-xl" :value="selectedJadwal?.status">
                                        <option value="aktif">Aktif</option>
                                        <option value="nonaktif">Non-Aktif</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Kuota</label>
                                    <input type="number" name="kuota" class="input input-bordered w-full bg-white rounded-xl" :value="selectedJadwal?.kuota" required>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-5 mb-6">
                                <div>
                                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Jam Mulai</label>
                                    <input type="time" name="jam_mulai" class="input input-bordered w-full bg-white rounded-xl" :value="selectedJadwal?.jam_mulai" required>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Jam Selesai</label>
                                    <input type="time" name="jam_selesai" class="input input-bordered w-full bg-white rounded-xl" :value="selectedJadwal?.jam_selesai" required>
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Hari
                                    Praktek</label>
                                <div class="flex flex-wrap gap-2">
                                    @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $day)
                                        <label class="cursor-pointer relative">
                                            <input type="checkbox" name="hari[]" value="{{ $day }}" class="peer sr-only"
                                                :checked="selectedJadwal?.hari?.includes('{{ $day }}')" />
                                            <div class="px-4 py-2 rounded-xl text-sm font-semibold border border-gray-200 text-gray-500 bg-white transition-all peer-checked:bg-brand-secondary peer-checked:text-white peer-checked:border-brand-secondary hover:bg-gray-50">
                                                {{ $day }}
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div class="mt-8 flex flex-row-reverse gap-3">
                                <button type="submit" class="btn bg-brand-secondary hover:bg-brand-secondary/90 text-white border-none px-6 rounded-xl shadow-lg hover:-translate-y-0.5 transition-all">Simpan Perubahan</button>
                                <button @click="editModalOpen = false" type="button" class="btn btn-ghost text-gray-500 rounded-xl">Batal</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
