@extends('layouts.sidebar')

@section('title', 'Resepsionis - Register Pasien')

@section('content')

<!-- WRAPPER ALPINE -->
<div 
    x-data="registerPasien()"
    x-init="openTambahPasien = false"
>

    <div class="bg-white p-6 rounded-2xl shadow-xl border border-gray-100">

        <!-- HEADER -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-[#2C3753]">Front Office</h1>
                <p class="text-gray-500 text-sm">Registrasi Pasien Baru dan Penambahan Antrian.</p>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 mt-4 sm:mt-0">

                <!-- Search Input -->
                <form method="GET" action="{{ route('staff.register-pasien') }}">
                    <input type="text" name="search" placeholder="Cari nama atau NIK pasien..."
                        value="{{ request('search') }}" 
                        class="input h-10 input-bordered border border-gray-300 rounded-xl shadow-md input-sm w-full sm:w-64 transition-all duration-300 ease-in-out focus:scale-105 focus:shadow-lg focus:border-blue-400 hover:shadow-md" />
                </form>

                <!-- Button Tambah Pasien -->
                <button 
                    @click="openTambahPasien=true"
                    class="btn  px-4 bg-blue-600 border border-blue-600 hover:bg-blue-700 rounded-xl active:scale-95 text-white shadow-md hover:shadow-lg transition-all duration-300 ease-in-out transform hover:scale-105 flex items-center justify-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Pasien
                </button>
            </div>
        </div>

        <!-- TABLE -->
        <div class="overflow-x-auto">
            <table class="table w-full">
                <thead class="bg-blue-50 text-blue-800 uppercase text-xs font-bold sticky top-0">
                    <tr>
                        <th class="py-4 pl-4">No.</th>
                        <th>Identitas Pasien</th>
                        <th>Tanggal Lahir</th>
                        <th>Jenis Kelamin</th>
                        <th>Alamat</th>
                        <th>No. HP</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @forelse($pasienData['data'] ?? [] as $index => $item)
                    <tr class="hover:bg-blue-50/40 transition">
                        
                        <td class="pl-4 font-mono font-bold text-lg text-blue-600">{{ ($pasienData['from'] ?? 0) + $index }}</td>
                        <td>
                            <div class="font-bold text-gray-800">{{ $item['nama_lengkap'] }}</div>
                            <div class="text-xs text-gray-400">NIK: {{ $item['nik'] }}</div>
                        </td>
                        <td class="text-sm">{{ $item['tgl_lahir'] }}</td>
                        <td class="text-sm">{{ $item['jenis_kelamin'] }}</td>
                        <td class="text-sm max-w-xs truncate">{{ $item['alamat_domisili'] }}</td>
                        <td class="text-sm">{{ $item['no_hp'] }}</td>
                        <td class="text-center">

                            <!-- 🎯 Button Click to OPEN MODAL -->
                            <button
                            data-patient='@json($item)'
                            @click="openModal(JSON.parse($event.currentTarget.dataset.patient))"
                            class="btn btn-sm border-none py-2 bg-blue-600 hover:bg-blue-800 rounded-xl text-white shadow-md">
                            Antrian
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5">Tidak ada data pasien ditemukan.</td>
                    </tr>
                    @endforelse

                    @if (empty($pasienData['data']) && request('search'))
                    <tr>
                        <td colspan="7" class="text-center py-4 text-gray-500 italic">Tidak ada pasien yang cocok dengan
                            pencarian: "{{ request('search') }}".</td>
                    </tr>
                    @endif
                </tbody>
            </table>
            <div class="my-4 mx-4">
                @if (!empty($pasienData) && ($pasienData['last_page'] ?? 0) > 1)
                    @php
                        // Inisialisasi Paginator secara manual
                        $paginator = app(Illuminate\Pagination\LengthAwarePaginator::class, [
                            'items' => $pasienData['data'],
                            'total' => $pasienData['total'],
                            'perPage' => $pasienData['per_page'],
                            'currentPage' => $pasienData['current_page'],
                            'options' => ['path' => request()->url(), 'query' => request()->query()]
                        ])->onEachSide(1);
                    @endphp

                    {{ $paginator->links() }}
                @endif
            </div>
        </div>
    </div>

    {{-- modal tambah antrian --}}
    <div 
        x-show="open"
        x-transition
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4"
    >
        <div @click.away="resetForm()" class="bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden">

            <!-- Header -->
            <div class="bg-blue-800 px-6 py-4 shadow flex justify-between items-center">
                <h3 class="text-lg font-bold text-white">Tambah Antrian Kunjungan</h3>
                <button @click="resetForm()" class="text-white text-xl">&times;</button>
            </div>

            <div class="p-6">
                <!-- Pasien Info -->    
                <template x-if="selected">
                    <div class="flex items-center gap-3 mb-6 bg-gray-50 p-3 rounded-xl border border-gray-200">
                        <div>
                            <p class="font-bold text-gray-800" x-text="selected.nama_lengkap"></p>
                            <p class="text-xs text-gray-500">
                                NIK: <span x-text="selected.nik"></span> |
                                Tgl Lahir: <span x-text="selected.tgl_lahir"></span>
                            </p>
                        </div>
                    </div>
                </template>

                <!-- FORM -->
                <form method="POST" action="{{ route('staff.register-pasien.kunjungan.store') }}">
                    @csrf

                    <input type="hidden" name="id_klinik" :value="idKlinik">
                    <input type="hidden" name="id_pasien" :value="selected ? selected.id : ''">
                    <input type="hidden" name="tgl_kunjungan" :value="tglKunjungan">
                    <input type="hidden" name="no_antrian" :value="newAntrianNumber()">
                    <input type="hidden" name="status" value="booking">
                    <input type="hidden" name="id_jadwal" :value="selectedJadwalId">
                    <input type="hidden" name="id_dokter" :value="selectedDokterId">

                    <!-- Dokter & Jadwal -->
                    <select
                        name="dokter_jadwal_combo"
                        x-model="selectedDokterJadwal"
                        class="select bg-white input select-bordered rounded-md border border-gray-300 w-full mb-4"
                    >
                        <option value="" disabled selected>-- Pilih Dokter dan Jadwal --</option>

                        <template x-for="dok in dokterList" :key="dok.id_jadwal">
                            <option 
                                :value="dok.id_dokter + '|' + dok.id_jadwal"
                                x-text="dok.nama_dokter + ' - ' + dok.hari + ' (' + dok.waktu + ')'"
                            ></option>
                        </template>
                    </select>

                    <!-- Keluhan -->
                    <label class="text-xs font-bold text-gray-500 mb-1 block">Keluhan</label>
                    <textarea name="keluhan" x-model="keluhan"
                        class="textarea border border-gray-300 rounded-xl input w-full h-24 mb-4"
                        placeholder="Tuliskan keluhan utama pasien..."></textarea>

                    <!-- Buttons -->
                    <div class="flex justify-end gap-3">
                        <button type="button" @click="resetForm()" class="btn bg-gray-500 hover:bg-gray-800 text-white rounded-xl">Batal</button>

                        <button 
                            type="submit"
                            :disabled="!selected || !selectedDokterJadwal || !keluhan"
                            class="btn rounded-xl bg-blue-700 hover:bg-blue-900 text-white disabled:opacity-50 disabled:cursor-not-allowed">
                            Simpan Antrian (Booking)
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>


    <!-- MODAL TAMBAH PASIEN -->
    <div 
        x-show="openTambahPasien"
        x-transition
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4"
        >
        <div @click.away="resetTambahPasien()" 
            class="bg-white rounded-2xl shadow-2xl w-full max-w-xl overflow-hidden">

                <div class="bg-blue-800 px-6 py-4 border-b border-blue-200 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-white">Tambah Pasien Baru</h3>
                    <button @click="resetTambahPasien()" class="text-white text-xl">&times;</button>
                </div>

            <form method="POST" action="{{ route('staff.register-pasien.store') }}" class="p-6 pt-0 space-y-5">
            @csrf
            
            <div class="bg-gray-100 p-3 -mx-6">
                <h4 class="text-lg font-semibold text-gray-700">Data Akun dan Identitas Pasien</h4>
            </div>

            <div class="flex flex-wrap -mx-2">
                <div class="w-full md:w-1/2 px-2 mb-4 md:mb-0">
                    <label class="text-xs font-bold text-gray-500 mb-1 block">Email <span class="text-red-500">*</span></label>
                    <input name="email" type="email" required x-model="newPasien.email"
                        class="input input-bordered w-full rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300 ease-in-out hover:shadow-md hover:scale-[1.005]">
                </div>
                <div class="w-full md:w-1/2 px-2">
                    <label class="text-xs font-bold text-gray-500 mb-1 block">Password <span class="text-red-500">*</span></label>
                    <input type="password" name="password" required x-model="newPasien.password"
                        class="input input-bordered w-full rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300 ease-in-out hover:shadow-md hover:scale-[1.005]">
                </div>
            </div>

            <div class="flex flex-wrap -mx-2">
                <div class="w-full md:w-1/2 px-2 mb-4 md:mb-0">
                    <label class="text-xs font-bold text-gray-500 mb-1 block">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input name="nama_lengkap" required x-model="newPasien.nama_lengkap"
                        class="input input-bordered w-full rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300 ease-in-out hover:shadow-md hover:scale-[1.005]">
                </div>
                <div class="w-full md:w-1/2 px-2">
                    <label class="text-xs font-bold text-gray-500 mb-1 block">NIK (Nomor Induk Kependudukan) <span class="text-red-500">*</span></label>
                    <input name="nik" required x-model="newPasien.nik"
                        class="input input-bordered w-full rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300 ease-in-out hover:shadow-md hover:scale-[1.005]">
                </div>
            </div>

            <div class="flex flex-wrap -mx-2">
                <div class="w-full md:w-1/3 px-2 mb-4 md:mb-0">
                    <label class="text-xs font-bold text-gray-500 mb-1 block">Tanggal Lahir <span class="text-red-500">*</span></label>
                    <input type="date" name="tgl_lahir" required x-model="newPasien.tgl_lahir"
                        class="input input-bordered w-full rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300 ease-in-out hover:shadow-md hover:scale-[1.005]">
                </div>
                <div class="w-full md:w-1/3 px-2 mb-4 md:mb-0">
                    <label class="text-xs font-bold text-gray-500 mb-1 block">Jenis Kelamin <span class="text-red-500">*</span></label>
                    <select name="jenis_kelamin" required x-model="newPasien.jenis_kelamin"
                        class="select select-bordered w-full rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300 ease-in-out hover:shadow-md hover:scale-[1.005]">
                        <option value="Laki-laki">Laki-laki</option> 
                        <option value="Perempuan">Perempuan</option>  
                    </select>
                </div>
                <div class="w-full md:w-1/3 px-2">
                    <label class="text-xs font-bold text-gray-500 mb-1 block">No HP <span class="text-red-500">*</span></label>
                    <input name="no_hp" required placeholder="Contoh: 08123456789" x-model="newPasien.no_hp"
                        class="input input-bordered w-full rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300 ease-in-out hover:shadow-md hover:scale-[1.005]">
                </div>
            </div>

            <div>
                <label class="text-xs font-bold text-gray-500 mb-1 block">Alamat Domisili <span class="text-red-500">*</span></label>
                <textarea name="alamat_domisili" required placeholder="Masukkan alamat lengkap pasien saat ini..." x-model="newPasien.alamat_domisili"
                    class="textarea border border-gray-300 rounded-xl w-full h-24 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300 ease-in-out hover:shadow-md hover:scale-[1.005]"></textarea>
            </div>

            <div class="bg-gray-100 p-3 -mx-6">
                <h4 class="text-lg font-semibold text-gray-700">Riwayat Kesehatan</h4>
            </div>
            
            <div class="flex flex-wrap -mx-2">
                <div class="w-full md:w-1/2 px-2 mb-4 md:mb-0">
                    <label class="text-xs font-bold text-gray-500 mb-1 block">Golongan Darah</label>
                    <input name="golongan_darah" placeholder="Cth: A, B, AB, atau O" x-model="newPasien.golongan_darah"
                        class="input input-bordered w-full rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300 ease-in-out hover:shadow-md hover:scale-[1.005]">
                </div>
                <div class="w-full md:w-1/2 px-2">
                    <label class="text-xs font-bold text-gray-500 mb-1 block">Riwayat Alergi</label>
                    <input name="riwayat_alergi" placeholder="Contoh: Udang, Obat tertentu (jika ada)" x-model="newPasien.riwayat_alergi"
                        class="input input-bordered w-full rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300 ease-in-out hover:shadow-md hover:scale-[1.005]">
                </div>
            </div>
            
            <p class="text-xs text-gray-500 pt-2"><span class="text-red-500">*</span> Wajib diisi.</p>

            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100 mt-6">
                <button type="button" @click="resetTambahPasien()" class="btn px-6 border border-gray-300 bg-gray-500 shadow-xl hover:bg-gray-700 text-white rounded-xl shadow-lg transition duration-200">Batal</button>
                
                <button 
                    type="submit"
                    :disabled="!isPasienFormValid()" 
                    class="btn px-6 rounded-xl bg-blue-600 hover:bg-blue-800 border border-gray-300 text-white shadow-xl transition duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                    Simpan Data Pasien
                </button>
            </div>
        </form>
        </div>
    </div>  

</div> <!-- end alpine wrapper -->


<script>
    function registerPasien() {
        return {
            open: false, 
        selected: null,
        keluhan: '',
        selectedDokterJadwal: '',
        selectedDokterId: '',
        selectedJadwalId: '',
        dokterList: @json($dokterJadwal),
        idKlinik: '{{ $idKlinik }}',
        tglKunjungan: '{{ date('Y-m-d') }}',

        openTambahPasien: false, 
        newPasien: { 
            nama_lengkap: '',
            nik: '',
            tgl_lahir: '',
            jenis_kelamin: 'Laki-laki', 
            alamat_domisili: '',
            no_hp: '',
            email: '',
            password: '',
            golongan_darah: '',
            riwayat_alergi: '',
        },

        resetTambahPasien() {
            this.openTambahPasien = false;
            this.newPasien = {
                nama_lengkap: '',
                nik: '',
                tgl_lahir: '',
                jenis_kelamin: 'Laki-laki',
                alamat_domisili: '',
                no_hp: '',
                email: '',
                password: '',
                golongan_darah:'',
                riwayat_alergi: '',
            };
        },
        openModal(pasien) {
            this.selected = pasien;
            this.open = true;
        },

        newAntrianNumber() {
            return '{{ $nextNomor }}';
        },

        resetForm() {
            this.open = false;
            this.selected = null;
            this.keluhan = '';
            this.selectedDokterJadwal = '';
            this.selectedDokterId = '';
            this.selectedJadwalId = '';
        },

        init() {
            this.$watch('selectedDokterJadwal', value => {
                if (!value) return;
                const [dok, jadwal] = value.split('|');
                this.selectedDokterId = dok;
                this.selectedJadwalId = jadwal;
            });
        }
    }
}
</script>
@endsection