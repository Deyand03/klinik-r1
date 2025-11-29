@extends('layouts.index')

@section('title', 'KlinikR1')

@section('content')
    <div class="bg-linear-to-b from-brand-tertiary to-[#2C3753] pt-16 pb-24 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto text-center">
            <h1 class="text-4xl font-bold text-white mb-2">
                Cari <span class="text-[#4cd6c0]">Dokter</span>
            </h1>
            <p class="text-gray-200 mb-10">Temukan Dokter dan Informasi Jadwal Praktik Disini</p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 max-w-4xl mx-auto">
                <div class="form-control w-full">
                    <label class="label"><span class="label-text text-white font-semibold">Klinik</span></label>
                    <select class="select select-bordered w-full text-gray-700 bg-white">
                        <option selected>Semua Klinik</option>
                        <option>Klinik Gigi</option>
                        <option>Klinik Umum</option>
                    </select>
                </div>
                <div class="form-control w-full">
                    <label class="label"><span class="label-text text-white font-semibold">Hari</span></label>
                    <select class="select select-bordered w-full text-gray-700 bg-white">
                        <option selected>Semua Hari</option>
                        <option>Senin</option>
                        <option>Selasa</option>
                    </select>
                </div>
                <div class="form-control w-full">
                    <label class="label"><span class="label-text text-white font-semibold">Gender</span></label>
                    <select class="select select-bordered w-full text-gray-700 bg-white">
                        <option selected>Semua Gender</option>
                        <option>Pria</option>
                        <option>Wanita</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-gray-50 py-12 px-4 sm:px-6 lg:px-8 -mt-8 rounded-t-3xl">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div
                    class="card card-side bg-white shadow-lg border border-gray-100 rounded-xl overflow-hidden flex flex-col sm:flex-row">
                    <figure class="sm:w-1/3 h-64 sm:h-auto relative">
                        <img src="https://placehold.co/300x400/png?text=Dokter+Wanita" alt="Dokter"
                            class="h-full w-full object-cover" />
                    </figure>
                    <div class="card-body sm:w-2/3 p-6">
                        <div class="block sm:hidden mb-4">
                            <h2 class="text-xl font-bold text-[#2C3753]">drg. Eugene Ahn</h2>
                            <hr class="border-gray-300 mt-2">
                        </div>
                        <div
                            class="hidden sm:block w-[calc(100%+24px)] border-b-2 border-l-2 border-[#2C3753] rounded-bl-4xl pl-5 mb-4 -mr-6 pr-6 -mt-6 pt-4 pb-4">
                            <h2 class="text-xl font-bold text-[#2C3753]">drg. Eugene Ahn</h2>
                        </div>
                        <div class="space-y-2 mb-4 px-0 sm:px-2">
                            <p class="flex items-center text-[#2C3753] font-bold text-lg"><span
                                    class="font-bold mr-1">Klinik:</span> Gigi</p>
                            <p class="text-green-500 font-bold flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Ada Jadwal Praktik Hari Ini
                            </p>
                        </div>
                        <div class="card-actions justify-end mt-auto">
                            <a href="{{ route('profil_dokter') }}"
                                class="btn bg-brand-tertiary hover:bg-[#5b78eb] text-white border-none w-full sm:w-auto btn-sm h-10 px-6 rounded-md normal-case font-medium text-base">Profil
                                & Jadwal Praktik</a>
                        </div>
                    </div>
                </div>

                <div
                    class="card card-side bg-white shadow-lg border border-gray-100 rounded-xl overflow-hidden flex flex-col sm:flex-row">
                    <figure class="sm:w-1/3 h-64 sm:h-auto relative">
                        <img src="https://placehold.co/300x400/333/fff?text=Dokter+Pria" alt="Dokter"
                            class="h-full w-full object-cover" />
                    </figure>
                    <div class="card-body sm:w-2/3 p-6">
                        <div class="block sm:hidden mb-4">
                            <h2 class="text-xl font-bold text-[#2C3753]">dr. Evan Lee</h2>
                            <hr class="border-gray-300 mt-2">
                        </div>
                        <div
                            class="hidden sm:block w-[calc(100%+24px)] border-b-2 border-l-2 border-[#2C3753] rounded-bl-4xl pl-5 mb-4 -mr-6 pr-6 -mt-6 pt-4 pb-4">
                            <h2 class="text-xl font-bold text-[#2C3753]">dr. Evan Lee</h2>
                        </div>
                        <div class="space-y-2 mb-4 px-0 sm:px-2">
                            <p class="flex items-center text-[#2C3753] font-bold text-lg"><span
                                    class="font-bold mr-1">Klinik:</span> Umum</p>
                            <p class="text-red-500 font-bold flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Tidak Ada Jadwal Praktik Hari Ini
                            </p>
                        </div>
                        <div class="card-actions justify-end mt-auto">
                            <button
                                class="btn bg-brand-tertiary hover:bg-[#5b78eb] text-white border-none w-full sm:w-auto btn-sm h-10 px-6 rounded-md normal-case font-medium text-base">Profil
                                & Jadwal Praktik</button>
                        </div>
                    </div>
                </div>

                <div
                    class="card card-side bg-white shadow-lg border border-gray-100 rounded-xl overflow-hidden flex flex-col sm:flex-row">
                    <figure class="sm:w-1/3 h-64 sm:h-auto relative">
                        <img src="https://placehold.co/300x400/png?text=Dokter+Wanita" alt="Dokter"
                            class="h-full w-full object-cover" />
                    </figure>
                    <div class="card-body sm:w-2/3 p-6">
                        <div class="block sm:hidden mb-4">
                            <h2 class="text-xl font-bold text-[#2C3753]">drg. Eugene Ahn</h2>
                            <hr class="border-gray-300 mt-2">
                        </div>
                        <div
                            class="hidden sm:block w-[calc(100%+24px)] border-b-2 border-l-2 border-[#2C3753] rounded-bl-4xl pl-5 mb-4 -mr-6 pr-6 -mt-6 pt-4 pb-4">
                            <h2 class="text-xl font-bold text-[#2C3753]">drg. Eugene Ahn</h2>
                        </div>
                        <div class="space-y-2 mb-4 px-0 sm:px-2">
                            <p class="flex items-center text-[#2C3753] font-bold text-lg"><span
                                    class="font-bold mr-1">Klinik:</span> Gigi</p>
                            <p class="text-green-500 font-bold flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Ada Jadwal Praktik Hari Ini
                            </p>
                        </div>
                        <div class="card-actions justify-end mt-auto">
                            <button
                                class="btn bg-brand-tertiary hover:bg-[#5b78eb] text-white border-none w-full sm:w-auto btn-sm h-10 px-6 rounded-md normal-case font-medium text-base">Profil
                                & Jadwal Praktik</button>
                        </div>
                    </div>
                </div>

                <div
                    class="card card-side bg-white shadow-lg border border-gray-100 rounded-xl overflow-hidden flex flex-col sm:flex-row">
                    <figure class="sm:w-1/3 h-64 sm:h-auto relative">
                        <img src="https://placehold.co/300x400/333/fff?text=Dokter+Pria" alt="Dokter"
                            class="h-full w-full object-cover" />
                    </figure>
                    <div class="card-body sm:w-2/3 p-6">
                        <div class="block sm:hidden mb-4">
                            <h2 class="text-xl font-bold text-[#2C3753]">dr. Evan Lee</h2>
                            <hr class="border-gray-300 mt-2">
                        </div>
                        <div
                            class="hidden sm:block w-[calc(100%+24px)] border-b-2 border-l-2 border-[#2C3753] rounded-bl-4xl pl-5 mb-4 -mr-6 pr-6 -mt-6 pt-4 pb-4">
                            <h2 class="text-xl font-bold text-[#2C3753]">dr. Evan Lee</h2>
                        </div>
                        <div class="space-y-2 mb-4 px-0 sm:px-2">
                            <p class="flex items-center text-[#2C3753] font-bold text-lg"><span
                                    class="font-bold mr-1">Klinik:</span> Umum</p>
                            <p class="text-red-500 font-bold flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Tidak Ada Jadwal Praktik Hari Ini
                            </p>
                        </div>
                        <div class="card-actions justify-end mt-auto">
                            <button
                                class="btn bg-brand-tertiary hover:bg-[#5b78eb] text-white border-none w-full sm:w-auto btn-sm h-10 px-6 rounded-md normal-case font-medium text-base">Profil
                                & Jadwal Praktik</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="card lg:card-side bg-white w-full rounded-none border-none flex flex-col lg:flex-row">

        <figure class="lg:w-1/2 min-h-[250px] lg:min-h-[350px] relative m-0 p-0">
            <img src="https://placehold.co/800x600/e2e8f0/888888?text=Fasilitas+Rumah+Sakit" alt="Fasilitas RS"
                class="absolute inset-0 w-full h-full object-cover" />
        </figure>

        <div class="card-body lg:w-1/2 p-6 lg:p-12 justify-center">
            <h3 class="text-[#4cd6c0] font-bold text-lg md:text-xl uppercase tracking-wider mb-1">
                Fasilitas dan Layanan
            </h3>

            <h2 class="text-[#3b4c7a] font-bold text-xl md:text-2xl mb-3 leading-tight">
                Layanan Prima dengan Fasilitas Terlengkap dan Terintegrasi
            </h2>

            <p class="text-gray-600 mb-6 leading-relaxed text-base">
                Kami menyediakan berbagai fasilitas medis modern untuk menunjang kesehatan Anda, mulai dari ruang
                rawat inap yang nyaman hingga peralatan medis terkini.
            </p>

            <div class="card-actions">
                <button
                    class="btn btn-md bg-brand-secondary hover:bg-[#2f7e72] text-white border-none px-6 rounded-full normal-case text-base shadow-md">
                    Lebih Lanjut
                </button>
            </div>
        </div>

    </div>
@endsection
