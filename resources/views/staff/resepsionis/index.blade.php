@extends('layouts.sidebar')

@section('title', 'Resepsionis - Check In')

@section('content')

<div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-[#2C3753]">Front Office</h1>
            <p class="text-gray-500 text-sm">Validasi kedatangan pasien booking online.</p>
        </div>
        <div class="flex gap-3">
            <form method="GET" action="{{ route('staff.dashboard') }}" class="transition-all duration-300">
            <input type="text" name="search" placeholder="Cari No. Antrian/Nama/NIK pasien..."
                value="{{ request('search') }}" 
                class="input h-10 input-bordered rounded-xl border border-gray-300 shadow-md input-sm w-full sm:w-64 transition-all duration-300 ease-in-out focus:scale-105 focus:shadow-lg focus:border-brand-secondary hover:shadow-md" />
            </form>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="table w-full">
            <thead class="bg-teal-50 text-brand-secondary uppercase text-xs font-bold">
                <tr>
                    <th class="py-4 pl-4">No. Antrian</th>
                    <th>Identitas Pasien</th>
                    <th>Tujuan Dokter</th>
                    <th>Status</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach ($antrian as $item)
                <tr class="hover:bg-teal-50/30 transition">
                    <td class="pl-4 font-mono font-bold text-lg text-teal-600">
                        {{ $item['no_antrian'] }}
                    </td>

                    <td>
                        <div class="font-bold text-gray-800">
                            {{ $item['pasien']['nama_lengkap'] }}
                        </div>
                        <div class="text-xs text-gray-400">
                            NIK: {{ $item['pasien']['nik'] }}
                        </div>
                    </td>

                    <td>
                        <div class="font-semibold text-gray-700">
                            {{ $item['dokter']['nama_lengkap'] }}
                        </div>
                        <div class="text-[10px] text-gray-400">
                            {{ $item['jadwal']['hari'] }} | {{ $item['jadwal']['jam_mulai'] }} - {{ $item['jadwal']['jam_selesai'] }}
                        </div>
                    </td>

                    <td>
                        @if($item['status'] === 'booking')
                            <div class="badge bg-teal-100 text-brand-secondary border-none text-xs font-bold">Booking</div>
                        @elseif($item['status'] === 'checkin')
                            <div class="badge bg-green-100 text-green-700 border-none text-xs font-bold">Menunggu Perawat</div>
                        @endif
                    </td>

                    <td class="text-center">
                        <form action="{{ route('staff.resepsionis.checkin', $item['id']) }}" method="POST">
                            @csrf
                            <button class="btn btn-sm px-4 bg-brand-secondary border border-none hover:bg-brand-secondary-hover rounded-xl active:scale-95 text-white shadow-md hover:shadow-lg transition-all duration-300 ease-in-out transform hover:scale-105">
                                Check-In
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>
</div>

@endsection
