@extends('layouts.index')

@section('title', 'Pembayaran - KlinikR1')

@section('content')
    <div class="bg-linear-to-b from-brand-tertiary to-[#2C3753] pt-16 pb-32 px-4 sm:px-6 lg:px-8 relative">
        <div class="max-w-7xl mx-auto">

            <div class="mb-6 md:mb-8">
                <a href="{{ route('profil_dokter') }}"
                    class="inline-flex items-center text-white hover:text-gray-200 transition-colors font-medium text-sm md:text-base">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali
                </a>
            </div>

            <div class="grid grid-cols-[100px_1fr] md:flex md:flex-row gap-4 md:gap-12 items-start">
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
                            class="text-xs sm:text-sm md:text-2xl opacity-90 font-medium badge badge-outline text-white md:border-none md:p-0">
                            Klinik: Gigi
                        </p>
                    </div>

                    <div class="col-span-2 bg-white rounded-2xl p-5 md:p-8 shadow-xl text-gray-700 mt-4 md:mt-0">
                        <h3 class="text-[#2C3753] font-bold text-base md:text-2xl mb-2 md:mb-4">Tentang Dokter</h3>
                        <p class="leading-relaxed text-xs md:text-lg text-gray-600">
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

    <div class="bg-gray-50 pb-20">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative -mt-12 z-10">

            <div class="bg-white rounded-3xl md:rounded-4xl shadow-xl overflow-hidden">

                <div class="bg-brand-secondary py-4 px-6 md:py-6 md:px-12">
                    <h2 class="text-white text-lg md:text-2xl font-bold">Upload Bukti Pembayaran</h2>
                </div>

                <div class="p-6 md:p-12">

                    <div class="bg-blue-50 border-l-4 border-[#2C3753] p-4 md:p-6 mb-8 rounded-r-lg">
                        <div class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 md:h-6 md:w-6 text-[#2C3753] mr-3 mt-1 shrink-0" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                <p class="text-[#2C3753] font-bold text-sm md:text-lg mb-1">Instruksi Pembayaran:</p>
                                <p class="text-gray-600 text-sm md:text-base leading-relaxed">
                                    Silahkan kirim pembayaran melalui nomor berikut: <br>
                                    <span
                                        class="font-bold text-lg md:text-2xl text-brand-secondary block my-1">0821-3123-1241
                                        <span class="text-gray-400 text-xs md:text-sm font-normal ml-1">(DANA)</span></span>
                                    Setelah itu, kirim bukti pembayaran dengan mengisi form di bawah ini.
                                </p>
                            </div>
                        </div>
                    </div>

                    <form action="" method="POST" enctype="multipart/form-data" class="space-y-6 md:space-y-8">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-[150px_1fr] gap-2 md:gap-4 items-center">
                            <label class="text-[#2C3753] font-semibold text-sm md:text-base">
                                Nama<span class="text-red-500">*</span>
                            </label>
                            <input readonly type="text"
                                class="input input-bordered input-md w-full bg-gray-200 border-gray-300 text-gray-700 text-sm md:text-base rounded-lg focus:outline-none focus:border-brand-secondary focus:ring-1 focus:ring-brand-secondary placeholder:text-gray-400"
                                value="Namaku" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-[150px_1fr] gap-2 md:gap-4 items-center">
                            <label class="text-[#2C3753] font-semibold text-sm md:text-base">
                                Klinik<span class="text-red-500">*</span>
                            </label>
                            <select
                                class="select select-bordered select-md w-full bg-white border-gray-300 text-gray-700 text-sm md:text-base rounded-lg focus:outline-none focus:border-brand-secondary focus:ring-1 focus:ring-brand-secondary">
                                <option disabled selected>Pilih jenis klinik</option>
                                <option>Klinik Gigi</option>
                                <option>Klinik Umum</option>
                                <option>Klinik Mata</option>
                            </select>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-[150px_1fr] gap-2 md:gap-4 items-start">
                            <label class="text-[#2C3753] font-semibold text-sm md:text-base mt-0 md:mt-2">
                                File Bukti<span class="text-red-500">*</span>
                            </label>

                            <div class="w-full">
                                <div
                                    class="relative flex items-center border border-gray-300 rounded-lg bg-white overflow-hidden group hover:border-brand-secondary transition-colors h-10">
                                    <div
                                        class="bg-gray-100 text-gray-600 font-medium text-sm py-2 px-4 border-r border-gray-300 group-hover:bg-gray-200 transition-colors h-full flex items-center whitespace-nowrap">
                                        Choose File
                                    </div>
                                    <span class="text-gray-400 text-sm px-3 italic truncate">No file chosen</span>

                                    <input type="file" name="bukti_bayar"
                                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                        accept=".jpg,.jpeg,.png"
                                        onchange="this.previousElementSibling.textContent = this.files[0] ? this.files[0].name : 'No file chosen'" />
                                </div>

                                <div class="mt-2">
                                    <p class="text-gray-500 italic text-xs md:text-sm">* File Bukti harus Extensi (JPG | PNG
                                        | JPEG)</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end pt-4">
                            <button
                                class="btn bg-[#3e54ac] hover:bg-[#32459b] text-white border-none px-8 py-2 md:px-10 md:py-3 text-sm md:text-base rounded-lg shadow-lg font-bold normal-case h-auto min-h-10">
                                KIRIM BUKTI
                            </button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
@endsection
