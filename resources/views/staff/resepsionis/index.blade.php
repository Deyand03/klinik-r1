@extends('layouts.sidebar')

@section('title', 'Resepsionis - Check In')

@section('content')
    {{-- DATA DUMMY HARDCODE --}}
    @php
        $antrian = [
            [
                'id' => 1,
                'no_antrian' => 'A-001',
                'nama' => 'Andi Pratama',
                'nik' => '327601230001',
                'dokter' => 'dr. Budi Santoso',
                'jam' => '08:00 - 12:00',
                'status' => 'Booking',
            ],
            [
                'id' => 2,
                'no_antrian' => 'A-002',
                'nama' => 'Siti Aminah',
                'nik' => '327601230002',
                'dokter' => 'dr. Budi Santoso',
                'jam' => '08:00 - 12:00',
                'status' => 'Booking',
            ],
        ];
    @endphp

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-[#2C3753]">Front Office</h1>
                <p class="text-gray-500 text-sm">Validasi kedatangan pasien booking online.</p>
            </div>
            <div class="badge badge-primary badge-outline font-bold">Filter: Booking Baru</div>
        </div>

        <div class="overflow-x-auto">
            <table class="table w-full">
                <thead class="bg-blue-50 text-blue-800 uppercase text-xs font-bold">
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
                        <tr class="hover:bg-blue-50/30 transition">
                            <td class="pl-4 font-mono font-bold text-lg text-blue-600">{{ $item['no_antrian'] }}</td>
                            <td>
                                <div class="font-bold text-gray-800">{{ $item['nama'] }}</div>
                                <div class="text-xs text-gray-400">NIK: {{ $item['nik'] }}</div>
                            </td>
                            <td>
                                <span class="badge badge-ghost text-xs">{{ $item['dokter'] }}</span>
                                <div class="text-[10px] text-gray-400 mt-1">{{ $item['jam'] }}</div>
                            </td>
                            <td>
                                <div class="badge bg-blue-100 text-blue-700 border-none text-xs font-bold">Menunggu
                                    Kedatangan</div>
                            </td>
                            <td class="text-center">
                                <form action="#" method="POST"> @csrf
                                    <button
                                        class="btn btn-sm bg-blue-600 hover:bg-blue-700 text-white border-none shadow-md shadow-blue-200 rounded-lg px-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
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
