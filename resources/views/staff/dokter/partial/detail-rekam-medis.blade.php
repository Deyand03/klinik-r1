 {{-- Kontainer Utama Modal --}}
 <div class="flex min-h-full items-center justify-center p-4" id="container-modal">
     <div
         class="relative bg-white w-full max-w-3xl rounded-xl shadow-2xl transform transition-all duration-300 overflow-hidden">

         {{-- Header Modal yang Dipercantik --}}
         <div class="bg-purple-700 px-6 py-4 flex justify-between items-center text-white">
             <div class="flex items-center space-x-3">
                 <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                         d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                 </svg>
                 <h3 class="text-xl font-extrabold">Pemeriksaan Medis Pasien</h3>
             </div>
             <button @click="openModal = false"
                 class="text-white hover:bg-purple-600 p-2 rounded-full transition duration-150">
                 <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                 </svg>
             </button>
         </div>

         {{-- Isi Modal --}}
         <div class="p-6 space-y-6">

             {{-- Review Data Perawat (Card Style) --}}
             <div class="bg-blue-50 p-5 rounded-xl border border-blue-200 shadow-inner">
                 <div class="flex items-center mb-3">
                     <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 mr-2" viewBox="0 0 20 20"
                         fill="currentColor">
                         <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                         <path fill-rule="evenodd"
                             d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h.01a1 1 100-2H10zm3 0a1 1 0 000 2h.01a1 1 100-2H13z"
                             clip-rule="evenodd" />
                     </svg>
                     <p class="font-extrabold text-blue-800 uppercase text-sm">📝 Data dari Perawat</p>
                 </div>
                 <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-700">
                     <div>
                         <p class="font-bold text-gray-500 mb-0.5">Anamnesa:</p>
                         <p class="pl-2 border-l-4 border-blue-400 italic" x-text="selectedPasien?.anamnesa"></p>
                     </div>
                     <div>
                         <p class="font-bold text-gray-500 mb-0.5">Vital Signs:</p>
                         <p class="pl-2 border-l-4 border-blue-400 italic" x-text="selectedPasien?.vital"></p>
                     </div>
                 </div>
             </div>

             <hr class="border-gray-100">

             {{-- Form Pemeriksaan Dokter --}}
             <form action="" id="form-diagnosa" method="POST" class="space-y-6">
                 @csrf

                 {{-- Diagnosa --}}
                 <div class="form-control">
                     <label class="label">
                         <span class="label-text font-bold text-gray-700">🩺 Diagnosa Dokter</span>
                     </label>
                     <input type="text" name="diagnosa"
                         class="input input-bordered input-primary border border-purple-400 rounded-sm w-full"
                         placeholder="Contoh: Hypertensi Grade 1, Common Cold..." required>
                 </div>

                 {{-- Resep Obat (Dinamis / Baris Obat) --}}
                 <div class="form-control">
                     <label class="label">
                         <span class="label-text font-bold text-gray-700">💊 Resep Obat</span>
                     </label>
                     <div class="space-y-3">
                         {{-- Baris Obat 1 (Ulangi ini untuk item obat tambahan) --}}
                         <div class="flex gap-3 items-end">
                             <div class="w-full">
                                 <label class="label-text text-xs text-gray-500 mb-0.5 block">Nama Obat</label>
                                 {{-- Menggunakan class select-bordered dan select-sm untuk tampilan yang lebih rapi --}}
                                 <select name=""
                                     class="select select-bordered w-full rounded-sm border-purple-400 border">
                                     <option disabled selected class="bg-indigo-400 text-white fw-semibold p-4">
                                         Pilih Obat dari Apotek</option>
                                     <option value="" class="bg-indigo-400 text-white fw-semibold p-4">
                                         Paracetamol 500mg</option>
                                     <option class="bg-indigo-400 text-white fw-semibold p-4">Amoxicillin 250mg
                                     </option>
                                     <option class="bg-indigo-400 text-white fw-semibold p-4">Amlodipine 5mg
                                     </option>
                                 </select>
                             </div>
                             <div class="w-24">
                                 <label class="label-text text-xs text-gray-500 mb-0.5 block">Jumlah</label>
                                 <input type="number" name="jumlah"
                                     class="input input-bordered w-full border rounded-sm border-purple-400"
                                     placeholder="Qty" min="1">
                             </div>
                             {{-- Tombol Hapus (Contoh jika menggunakan fitur tambah/hapus) --}}
                             {{-- <button type="button" class="btn btn-ghost btn-circle text-red-500 hover:bg-red-50">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                </button> --}}
                         </div>
                         <p class="text-xs text-gray-500 italic mt-1">* Pilih obat dari stok apotek. Anda bisa
                             menambahkan baris resep lain.</p>
                     </div>
                 </div>
                 <div class="form-control">
                     <label class="label">
                         <span class="label-text font-bold text-gray-700">💊 Harga</span>
                     </label>
                     <div class="space-y-3">
                         {{-- Baris Obat 1 (Ulangi ini untuk item obat tambahan) --}}
                         <div class="flex gap-3 items-end">

                             <div class="w-full">
                                 <label class="label-text text-xs text-gray-500 mb-0.5 block">Harga obat</label>
                                 <input type="number" name="harga"
                                     class="input input-bordered w-full border rounded-sm border-purple-400"
                                     placeholder="Masukkan harga" min="1">
                             </div>
                             {{-- Tombol Hapus (Contoh jika menggunakan fitur tambah/hapus) --}}
                             {{-- <button type="button" class="btn btn-ghost btn-circle text-red-500 hover:bg-red-50">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                </button> --}}
                         </div>
                         <p class="text-xs text-gray-500 italic mt-1">* Pilih obat dari stok apotek. Anda bisa
                             menambahkan baris resep lain.</p>
                     </div>
                 </div>

                 {{-- Catatan --}}
                 <div class="form-control">
                     <label class="label mb-2">
                         <span class="label-text font-bold text-gray-700">📝 Catatan / Saran Tambahan</span>
                     </label>
                     <textarea name="catatan_dokter"
                         class="textarea textarea-bordered h-24 w-full border border-purple-400 rounded-sm"
                         placeholder="Istirahat cukup, kurangi makanan berminyak, kontrol seminggu lagi..."></textarea>
                 </div>

                 {{-- Aksi Modal --}}
                 <div class="modal-action flex justify-end pt-4 border-t border-gray-100">
                     <button type="button" @click="openModal = false"
                         class="btn btn-ghost hover:bg-gray-100 px-6">Batal</button>
                     <button id="btn-selesai" type="submit"
                         class="btn bg-purple-600 hover:bg-purple-700 text-white border-none shadow-md px-6">
                         Selesai & Lanjutkan ke Kasir
                     </button>
                 </div>
             </form>
         </div>
     </div>
 </div>
