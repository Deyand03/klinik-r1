@extends('layouts.index')

@section('title', 'Profil Dokter')

@section('content')
    <div class="bg-linear-to-b from-brand-tertiary to-[#2C3753] pt-16 pb-24 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">

            <div class="mb-6 md:mb-8">
                <a href="{{ route('cari_dokter') }}"
                    class="inline-flex items-center text-white hover:text-gray-200 transition-colors font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali
                </a>
            </div>

            <div class="grid grid-cols-[110px_1fr] md:flex md:flex-row gap-4 md:gap-12 items-start">

                <div class="col-span-1 md:w-1/3 lg:w-1/4 shrink-0">
                    <div
                        class="aspect-3/4 relative rounded-2xl overflow-hidden shadow-2xl border-2 md:border-4 border-white/20">
                        <img src="https://placehold.co/600x800/png?text=drg.+Eugene" alt="drg. Eugene Ahn"
                            class="object-cover w-full h-full" />
                    </div>
                </div>

                <div class="contents md:flex md:flex-col md:w-2/3 lg:w-3/4 md:justify-center">
                    <div class="col-span-1 text-white self-center md:self-start mb-0 md:mb-8">
                        <h1 class="text-xl sm:text-2xl md:text-5xl font-bold mb-1 md:mb-3 leading-tight">drg. Eugene Ahn
                        </h1>
                        <p
                            class="text-sm sm:text-base md:text-2xl opacity-90 font-medium badge badge-outline text-white md:border-none md:p-0">
                            Klinik: Gigi</p>
                    </div>

                    <div class="col-span-2 bg-white rounded-2xl p-6 md:p-8 shadow-xl text-gray-700 mt-4 md:mt-0">
                        <h3 class="text-[#2C3753] font-bold text-lg md:text-2xl mb-2 md:mb-4">Tentang Dokter</h3>
                        <p class="leading-relaxed text-sm md:text-lg text-gray-600">
                            Eugene adalah dokter gigi yang berpengalaman dalam perawatan konservasi, estetika, dan
                            penanganan pasien dengan berbagai kebutuhan, termasuk yang memiliki kecemasan saat berobat.
                            Selama bertahun-tahun bekerja di klinik keluarga dan layanan gigi komunitas, ia terbiasa
                            menangani kasus restoratif yang beragam serta berkolaborasi dengan spesialis lain untuk
                            memastikan pasien mendapatkan hasil terbaik.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="bg-white py-12 md:py-16 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">

                <div class="w-full">
                    <h3 class="text-[#2C3753] font-bold text-xl md:hidden mb-4">Jadwal Praktik</h3>
                    <div class="overflow-x-auto rounded-xl shadow-lg border border-gray-200">
                        <table class="table w-full min-w-[600px]">
                            <thead class="bg-brand-tertiary text-white text-base">
                                <tr>
                                    <th class="py-4 pl-6 text-center w-1/3">Hari</th>
                                    <th class="py-4 text-center w-1/3">Jam Praktik</th>
                                    <th class="py-4 pr-6 text-center w-1/3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-700 font-medium text-base bg-white">
                                <tr class="hover:bg-gray-50 border-b border-gray-100 align-middle">
                                    <td class="py-4 pl-6 text-center">Senin</td>
                                    <td class="py-4 text-center">07:00 - 10:00</td>
                                    <td class="py-4 pr-6 text-center">
                                        <button
                                            class="btn btn-sm bg-brand-secondary hover:bg-emerald-600 text-white border-none shadow-md w-full px-6 whitespace-nowrap">Booking</button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50 border-b border-gray-100 align-middle">
                                    <td class="py-4 pl-6 text-center">Selasa</td>
                                    <td class="py-4 text-center">07:00 - 10:00</td>
                                    <td class="py-4 pr-6 text-center">
                                        <a href="{{ route('pembayaran') }}"
                                            class="btn btn-sm bg-brand-secondary hover:bg-emerald-600 text-white border-none shadow-md w-full px-6 whitespace-nowrap">Booking</a>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50 border-b border-gray-100 align-middle">
                                    <td class="py-4 pl-6 text-center">Rabu</td>
                                    <td class="py-4 text-center">13:00 - 15:00</td>
                                    <td class="py-4 pr-6 text-center">
                                        <button
                                            class="btn btn-sm bg-brand-secondary hover:bg-emerald-600 text-white border-none shadow-md w-full px-6 whitespace-nowrap">Booking</button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50 border-b border-gray-100 align-middle">
                                    <td class="py-4 pl-6 text-center">Kamis</td>
                                    <td class="py-4 text-center">10:00 - 12:00</td>
                                    <td class="py-4 pr-6 text-center">
                                        <button
                                            class="btn btn-sm bg-brand-secondary hover:bg-emerald-600 text-white border-none shadow-md w-full px-6 whitespace-nowrap">Booking</button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50 align-middle">
                                    <td class="py-4 pl-6 text-center">Jum'at</td>
                                    <td class="py-4 text-center">07:00 - 12:00</td>
                                    <td class="py-4 pr-6 text-center">
                                        <button
                                            class="btn btn-sm bg-brand-secondary hover:bg-emerald-600 text-white border-none shadow-md w-full px-6 whitespace-nowrap">Booking</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <p class="text-xs text-gray-400 mt-2 italic sm:hidden">* Geser tabel ke samping untuk booking</p>
                </div>

                <div class="card bg-white shadow-lg border border-gray-200 rounded-xl p-6 lg:p-10 h-full">
                    <h3 class="text-[#2C3753] font-bold text-xl md:text-2xl mb-6">Pengalaman Bekerja</h3>
                    <ul class="list-disc list-inside space-y-4 text-gray-600 font-medium text-lg">
                        <li class="pl-2">6 Tahun praktik klinik</li>
                        <li class="pl-2">Pengalaman layanan gigi komunitas</li>
                        <li class="pl-2">Penanganan pasien seluruh usia</li>
                    </ul>
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
            <h3 class="text-brand-secondary font-bold text-lg md:text-xl uppercase tracking-wider mb-1">Fasilitas dan
                Layanan</h3>
            <h2 class="text-[#3b4c7a] font-bold text-xl md:text-2xl mb-3 leading-tight">Layanan Prima dengan Fasilitas
                Terlengkap dan Terintegrasi</h2>
            <p class="text-gray-600 mb-6 leading-relaxed text-base">Kami menyediakan berbagai fasilitas medis modern untuk
                menunjang kesehatan Anda, mulai dari ruang rawat inap yang nyaman hingga peralatan medis terkini.</p>
            <div class="card-actions">
                <button
                    class="btn btn-md bg-brand-secondary hover:bg-[#2f7e72] text-white border-none px-6 rounded-full normal-case text-base shadow-md">Lebih
                    Lanjut</button>
            </div>
        </div>
    </div>
@endsection
