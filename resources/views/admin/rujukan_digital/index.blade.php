@extends('layouts.sidebar')
@section('title', 'Rujukan Digital')
@section('content')
    <div x-data="{
        editModalOpen: false,
        addModalOpen: false,
        selectedJadwal: null,
        searchTerm: '',
        filterTanggal: '',
    
        // Simpan URL template dari Laravel di sini
        //updateUrlTemplate: '{{ route('admin.jadwal-dokter.edit', 999) }}',
    
        openEdit(jadwal) {
            this.selectedJadwal = jadwal;
            this.editModalOpen = true;
        }
    }">

        {{-- Page Header --}}
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
            <div>
                <h1 class="text-2xl font-bold text-brand-dark">Rujukan Digital Pasien</h1>
                <p class="text-gray-500 text-sm mt-1">Buat surat rujukan untuk pasien di sini.</p>
            </div>

            <button @click="addModalOpen = true"
                class="btn bg-brand-secondary hover:bg-brand-secondary/90 text-white border-none gap-2 shadow-lg shadow-brand-secondary/30 rounded-xl px-6 transform hover:-translate-y-1 transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Rujukan Baru
            </button>
        </div>

        {{-- Filter Bar --}}
        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 mb-8">
            <div class="flex flex-col md:flex-row gap-4 items-end">
                <!-- Cari Nama -->
                <div class="form-control w-full md:flex-1">
                    <label class="label pb-1">
                        <span class="label-text font-bold text-gray-500 text-xs uppercase tracking-wider">Cari Dokter</span>
                    </label>
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
                        <input type="text" x-model="searchTerm" placeholder="Ketik nama dokter..."
                        class="input input-bordered w-full pl-10 bg-gray-50 focus:bg-white focus:border-brand-secondary rounded-xl transition-all" />
                    </div>
                </div>

                <!-- Filter Hari -->
                <div class="form-control w-full md:w-48">
                    <label class="label pb-1">
                        <span class="label-text font-bold text-gray-500 text-xs uppercase tracking-wider">Tanggal
                            Rujukan</span>
                    </label>
                    <input type="date" class="input" x-model="filterTanggal" />
                </div>

                <button @click="searchTerm=''; filterTanggal=''" type="button"
                    class="btn btn-outline border-gray-200 text-gray-600 hover:bg-gray-100 hover:border-gray-300 w-full md:w-auto rounded-xl">
                    Reset
                </button>
            </div>
        </div>
    </div>

@endsection
